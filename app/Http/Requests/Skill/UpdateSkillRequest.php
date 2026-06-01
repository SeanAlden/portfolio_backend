<?php

declare(strict_types=1);

namespace App\Http\Requests\Skill;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'skill_category_id' => ['sometimes', 'required', 'integer', 'exists:skill_categories,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'percentage' => ['sometimes', 'required', 'integer', 'min:0', 'max:100'],
        ];
    }
}
