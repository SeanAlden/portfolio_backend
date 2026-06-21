<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use ValidationException;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // Dependency Injection dari AuthService
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * Endpoint Login Admin
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->loginAdmin($request);

            return response()->json([
                'status' => 'success',
                'message' => 'Autentikasi berhasil.',
                'data' => $result
            ], Response::HTTP_OK);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Endpoint Logout Admin
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logoutAdmin($request->user());

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil logout, session token dicabut.'
        ], Response::HTTP_OK);
    }

    /**
     * Endpoint Update Profile Admin
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'], // Maks 2MB
        ]);

        // Proses upload gambar ke S3 jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image) {
                \Illuminate\Support\Facades\Storage::disk('s3')->delete($user->image);
            }
            // Simpan gambar baru
            $path = $request->file('image')->store('users', 's3');
            \Illuminate\Support\Facades\Storage::disk('s3')->setVisibility($path, 'public');
            $validated['image'] = $path;
        }

        // Update data user
        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui.',
            'data' => $user
        ], Response::HTTP_OK);
    }
}
