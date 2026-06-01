<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Memastikan education_id terdaftar di tabel educations
            'education_id' => ['required', 'integer', 'exists:educations,id'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:255'],
            'points' => ['required', 'array', 'min:1'], // Harus array dan minimal isi 1
            'points.*' => ['required', 'string'], // Setiap poin dalam array harus berupa teks
        ];
    }
}
