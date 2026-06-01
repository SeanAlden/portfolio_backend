<?php

declare(strict_types=1);

namespace App\Http\Requests\SkillCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID dari URL parameter agar validasi unique mengecualikan data ini sendiri
        $categoryId = $this->route('skill_category');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255', 'unique:skill_categories,name,' . $categoryId],
        ];
    }
}
