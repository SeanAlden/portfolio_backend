<?php

declare(strict_types=1);

namespace App\Http\Requests\Education;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autorisasi akan ditangani oleh Middleware Sanctum di routes
    }

    public function rules(): array
    {
        return [
            'university' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:255'],
            'gpa' => ['required', 'string', 'max:10'],
        ];
    }
}
