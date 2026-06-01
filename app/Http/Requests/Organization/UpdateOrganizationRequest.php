<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'education_id' => ['sometimes', 'required', 'integer', 'exists:educations,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'role' => ['sometimes', 'required', 'string', 'max:255'],
            'period' => ['sometimes', 'required', 'string', 'max:255'],
            'points' => ['sometimes', 'required', 'array', 'min:1'],
            'points.*' => ['sometimes', 'required', 'string'],
        ];
    }
}
