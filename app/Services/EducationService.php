<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Education;
use Illuminate\Database\Eloquent\Collection;

class EducationService
{
    /**
     * Get all educations with their relations (Eager Loading).
     */
    public function getAllEducations(): Collection
    {
        // with() memuat relasi sekaligus agar database tidak dipanggil berulang-ulang
        return Education::with(['organizations', 'projects'])
            ->latest()
            ->get();
    }

    /**
     * Get a single education by ID.
     */
    public function getEducationById(int $id): Education
    {
        return Education::with(['organizations', 'projects'])->findOrFail($id);
    }

    /**
     * Create a new education record.
     */
    public function createEducation(array $data): Education
    {
        return Education::create($data);
    }

    /**
     * Update an existing education record.
     */
    public function updateEducation(int $id, array $data): Education
    {
        $education = $this->getEducationById($id);

        $education->update($data);

        // Refresh model untuk mendapatkan data terbaru termasuk jika ada perubahan relasi
        return $education->refresh();
    }

    /**
     * Delete an education record.
     */
    public function deleteEducation(int $id): bool
    {
        $education = $this->getEducationById($id);

        return $education->delete();
    }
}
