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
}
