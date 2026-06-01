<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'education_id' => $this->education_id,
            'name' => $this->name,
            'role' => $this->role,
            'period' => $this->period,
            'points' => $this->points, // Otomatis menjadi array karena $casts di Model
            // Menampilkan data universitas terkait jika di-eager load
            'education' => new EducationResource($this->whenLoaded('education')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
