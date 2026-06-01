<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'education_id' => $this->education_id,
            'name' => $this->name,
            'desc' => $this->desc,
            'tech' => $this->tech,
            'github_urls' => $this->github_urls,
            // URL S3 untuk gambar proyek
            'image_url' => $this->image ? Storage::disk('s3')->url($this->image) : null,
            'image_path' => $this->image,
            // Eager loading relasi edukasi
            'education' => new EducationResource($this->whenLoaded('education')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
