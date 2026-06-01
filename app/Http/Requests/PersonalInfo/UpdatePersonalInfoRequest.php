<?php

declare(strict_types=1);

namespace App\Http\Requests\PersonalInfo;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'location' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'max:50'],
            'email' => ['sometimes', 'required', 'email', 'max:255'],
            'linkedin' => ['sometimes', 'required', 'string', 'max:255'],
            'github' => ['sometimes', 'required', 'string', 'max:255'],
            'summary' => ['sometimes', 'required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
