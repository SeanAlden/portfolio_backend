<?php

declare(strict_types=1);

namespace App\Http\Requests\PersonalInfo;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'linkedin' => ['required', 'string', 'max:255'],
            'github' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            // Validasi file gambar maksimal 2MB
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], 
        ];
    }
}
