<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'education_id' => ['nullable', 'integer', 'exists:educations,id'],
            'name' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
            
            // Validasi Array Tech
            'tech' => ['required', 'array', 'min:1'],
            'tech.*' => ['required', 'string'],
            
            // Validasi Array of Objects untuk GitHub URLs
            'github_urls' => ['required', 'array'],
            'github_urls.*.label' => ['required', 'string', 'max:255'],
            'github_urls.*.url' => ['required', 'url'], // Pastikan formatnya adalah URL valid
            
            // Validasi Gambar S3
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
