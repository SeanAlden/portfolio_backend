<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

class OrganizationService
{
    /**
     * Mengambil seluruh data organisasi beserta data edukasinya.
     */
    public function getAllOrganizations(): Collection
    {
        return Organization::with('education')->latest()->get();
    }

    /**
     * Mengambil satu data organisasi berdasarkan ID.
     */
    public function getOrganizationById(int $id): Organization
    {
        return Organization::with('education')->findOrFail($id);
    }

    /**
     * Membuat data organisasi baru.
     */
    public function createOrganization(array $data): Organization
    {
        return Organization::create($data);
    }

    /**
     * Memperbarui data organisasi.
     */
    public function updateOrganization(int $id, array $data): Organization
    {
        $organization = $this->getOrganizationById($id);

        $organization->update($data);

        return $organization->refresh();
    }

    /**
     * Menghapus data organisasi.
     */
    public function deleteOrganization(int $id): bool
    {
        $organization = $this->getOrganizationById($id);

        return $organization->delete();
    }
}
