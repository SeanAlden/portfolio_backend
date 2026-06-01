<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Collection;

class ExperienceService
{
    /**
     * Mengambil semua data pengalaman kerja, diurutkan dari yang terbaru.
     */
    public function getAllExperiences(): Collection
    {
        return Experience::latest()->get();
    }

    /**
     * Mengambil satu data pengalaman berdasarkan ID.
     */
    public function getExperienceById(int $id): Experience
    {
        return Experience::findOrFail($id);
    }

    /**
     * Membuat data pengalaman baru.
     */
    public function createExperience(array $data): Experience
    {
        return Experience::create($data);
    }

    /**
     * Memperbarui data pengalaman.
     */
    public function updateExperience(int $id, array $data): Experience
    {
        $experience = $this->getExperienceById($id);

        $experience->update($data);

        return $experience->refresh();
    }

    /**
     * Menghapus data pengalaman.
     */
    public function deleteExperience(int $id): bool
    {
        $experience = $this->getExperienceById($id);

        return $experience->delete();
    }
}
