<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Eksekusi logika login dan pembuatan Token Sanctum.
     */
    public function loginAdmin(LoginRequest $request): array
    {
        $request->ensureIsNotRateLimited();

        $user = User::where('email', $request->email)->first();

        // Verifikasi kecocokan user dan password hashed
        if (! $user || ! Hash::check($request->password, $user->password)) {
            $request->hitRateLimiter();

            throw ValidationException::withMessages([
                'email' => ['Kredensial yang Anda masukkan salah.'],
            ]);
        }

        $request->clearRateLimiter();

        // Generate token dengan kemampuan (abilities) sebagai admin portfolio
        $token = $user->createToken('admin_portfolio_token', ['admin:access'])->plainTextToken;

        return [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ];
    }

    /**
     * Eksekusi logika logout (Revoke Token).
     */
    public function logoutAdmin(User $user): void
    {
        // Menghapus token yang saat ini digunakan untuk request
        $user->currentAccessToken()->delete();
    }
}
