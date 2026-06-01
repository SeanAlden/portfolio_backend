<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'university' => $this->university,
            'degree' => $this->degree,
            'period' => $this->period,
            'gpa' => $this->gpa,
            // whenLoaded mencegah error N+1 query jika relasi belum di-load
            'organizations' => $this->whenLoaded('organizations'),
            'projects' => $this->whenLoaded('projects'),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
