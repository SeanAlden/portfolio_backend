<?php

declare(strict_types=1);

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'type' => ['sometimes', 'required', 'string', 'max:255'],
            'period' => ['sometimes', 'required', 'string', 'max:255'],
            'points' => ['sometimes', 'required', 'array', 'min:1'],
            'points.*' => ['sometimes', 'required', 'string'],
        ];
    }
}
