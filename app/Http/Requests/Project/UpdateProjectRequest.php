<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'education_id' => ['sometimes', 'nullable', 'integer', 'exists:educations,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'desc' => ['sometimes', 'required', 'string'],
            
            'tech' => ['sometimes', 'required', 'array', 'min:1'],
            'tech.*' => ['sometimes', 'required', 'string'],
            
            'github_urls' => ['sometimes', 'required', 'array'],
            'github_urls.*.label' => ['sometimes', 'required', 'string', 'max:255'],
            'github_urls.*.url' => ['sometimes', 'required', 'url'],
            
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
