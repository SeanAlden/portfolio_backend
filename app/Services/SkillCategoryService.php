<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Collection;

class SkillCategoryService
{
    /**
     * Mengambil semua kategori skill beserta detail skill di dalamnya.
     */
    public function getAllCategories(): Collection
    {
        return SkillCategory::with('skills')->latest()->get();
    }

    /**
     * Mengambil satu kategori berdasarkan ID.
     */
    public function getCategoryById(int $id): SkillCategory
    {
        return SkillCategory::with('skills')->findOrFail($id);
    }

    /**
     * Membuat kategori baru.
     */
    public function createCategory(array $data): SkillCategory
    {
        return SkillCategory::create($data);
    }

    /**
     * Memperbarui kategori.
     */
    public function updateCategory(int $id, array $data): SkillCategory
    {
        $category = $this->getCategoryById($id);

        $category->update($data);

        return $category->refresh();
    }

    /**
     * Menghapus kategori (dan otomatis menghapus skill di dalamnya berkat cascadeOnDelete di migrasi).
     */
    public function deleteCategory(int $id): bool
    {
        $category = $this->getCategoryById($id);

        return $category->delete();
    }
}
