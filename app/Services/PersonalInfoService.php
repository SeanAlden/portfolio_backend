<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\PersonalInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class PersonalInfoService
{
    public function getAllInfos(): Collection
    {
        return PersonalInfo::latest()->get();
    }

    public function getInfoById(int $id): PersonalInfo
    {
        return PersonalInfo::findOrFail($id);
    }

    public function createInfo(array $data): PersonalInfo
    {
        $data = $this->handlePhotoUpload($data);
        return PersonalInfo::create($data);
    }

    public function updateInfo(int $id, array $data): PersonalInfo
    {
        $info = $this->getInfoById($id);

        // Jika ada foto baru yang diunggah, hapus foto lama dari S3
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            if ($info->photo) {
                Storage::disk('s3')->delete($info->photo);
            }
        }

        $data = $this->handlePhotoUpload($data);

        $info->update($data);

        return $info->refresh();
    }

    public function deleteInfo(int $id): bool
    {
        $info = $this->getInfoById($id);

        // Hapus foto dari S3 sebelum menghapus data dari database
        if ($info->photo) {
            Storage::disk('s3')->delete($info->photo);
        }

        return $info->delete();
    }

    /**
     * Helper method untuk menangani proses upload ke S3.
     */
    private function handlePhotoUpload(array $data): array
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            // Upload ke folder 'profile' di bucket S3 Anda
            $path = $data['photo']->store('profile', 's3');

            // Atur agar file dapat diakses oleh publik (Next.js)
            Storage::disk('s3')->setVisibility($path, 'public');

            // Ganti objek UploadedFile dengan path string untuk disimpan ke DB
            $data['photo'] = $path;
        }

        return $data;
    }
}
