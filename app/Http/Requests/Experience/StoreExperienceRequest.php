<?php

declare(strict_types=1);

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:255'],
            'points' => ['required', 'array', 'min:1'], // Harus berupa array dan minimal 1 poin
            'points.*' => ['required', 'string'], // Setiap isi array wajib berupa teks
        ];
    }
}
