<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Memastikan request tidak melakukan brute-force.
     * Standar Senior wajib memikirkan aspek keamanan ini.
     */
    public function ensureIsNotRateLimited(): void
    {
        $throttleKey = Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => [__('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ])],
            ]);
        }
    }

    public function hitRateLimiter(): void
    {
        $throttleKey = Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
        RateLimiter::hit($throttleKey, 60); // Lock selama 1 menit jika gagal 5 kali
    }

    public function clearRateLimiter(): void
    {
        $throttleKey = Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
        RateLimiter::clear($throttleKey);
    }
}
