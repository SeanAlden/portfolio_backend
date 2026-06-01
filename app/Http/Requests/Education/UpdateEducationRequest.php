<?php

declare(strict_types=1);

namespace App\Http\Requests\Education;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Menggunakan 'sometimes' agar admin bisa update sebagian data saja (PATCH method)
        return [
            'university' => ['sometimes', 'required', 'string', 'max:255'],
            'degree' => ['sometimes', 'required', 'string', 'max:255'],
            'period' => ['sometimes', 'required', 'string', 'max:255'],
            'gpa' => ['sometimes', 'required', 'string', 'max:10'],
        ];
    }
}
