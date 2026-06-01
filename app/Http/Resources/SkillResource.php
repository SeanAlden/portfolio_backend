<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'skill_category_id' => $this->skill_category_id,
            'name' => $this->name,
            'percentage' => $this->percentage,
            // Memuat relasi kategori jika di-eager load
            'category' => new SkillCategoryResource($this->whenLoaded('skillCategory')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
