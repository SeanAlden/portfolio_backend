<?php

declare(strict_types=1);

namespace App\Http\Requests\Skill;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Memastikan ID kategori valid dan ada di tabel skill_categories
            'skill_category_id' => ['required', 'integer', 'exists:skill_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            // Memastikan persentase adalah angka antara 0 hingga 100
            'percentage' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }
}
