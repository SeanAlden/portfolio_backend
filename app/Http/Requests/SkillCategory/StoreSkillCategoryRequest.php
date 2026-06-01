<?php

declare(strict_types=1);

namespace App\Http\Requests\SkillCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // unique:skill_categories mencegah duplikasi nama kategori
            'name' => ['required', 'string', 'max:255', 'unique:skill_categories,name'],
        ];
    }
}
