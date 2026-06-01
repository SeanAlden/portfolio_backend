<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'phone' => $this->phone,
            'email' => $this->email,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'summary' => $this->summary,
            // Jika foto ada, kembalikan URL utuh dari S3. Jika tidak, kembalikan null.
            'photo_url' => $this->photo ? Storage::disk('s3')->url($this->photo) : null,
            'photo_path' => $this->photo, // Path aslinya tetap kita kirim
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
