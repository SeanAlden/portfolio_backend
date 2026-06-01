<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;

class SkillService
{
    /**
     * Mengambil semua skill beserta info kategorinya.
     */
    public function getAllSkills(): Collection
    {
        return Skill::with('skillCategory')->latest()->get();
    }

    /**
     * Mengambil satu skill berdasarkan ID.
     */
    public function getSkillById(int $id): Skill
    {
        return Skill::with('skillCategory')->findOrFail($id);
    }

    /**
     * Membuat skill baru.
     */
    public function createSkill(array $data): Skill
    {
        return Skill::create($data);
    }

    /**
     * Memperbarui data skill.
     */
    public function updateSkill(int $id, array $data): Skill
    {
        $skill = $this->getSkillById($id);
        
        $skill->update($data);
        
        return $skill->refresh();
    }

    /**
     * Menghapus skill.
     */
    public function deleteSkill(int $id): bool
    {
        $skill = $this->getSkillById($id);
        
        return $skill->delete();
    }
}
