<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public function getAllProjects(): Collection
    {
        return Project::with('education')->latest()->get();
    }

    public function getProjectById(int $id): Project
    {
        return Project::with('education')->findOrFail($id);
    }

    public function createProject(array $data): Project
    {
        $data = $this->handleImageUpload($data);
        return Project::create($data);
    }

    public function updateProject(int $id, array $data): Project
    {
        $project = $this->getProjectById($id);

        // Hapus gambar lama jika ada unggahan gambar baru
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($project->image) {
                Storage::disk('s3')->delete($project->image);
            }
        }

        $data = $this->handleImageUpload($data);

        $project->update($data);

        return $project->refresh();
    }

    public function deleteProject(int $id): bool
    {
        $project = $this->getProjectById($id);

        // Hapus gambar dari S3 sebelum menghapus record dari database
        if ($project->image) {
            Storage::disk('s3')->delete($project->image);
        }

        return $project->delete();
    }

    /**
     * Helper untuk upload ke S3.
     */
    private function handleImageUpload(array $data): array
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Simpan ke folder 'projects' di S3 bucket
            $path = $data['image']->store('projects', 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $data['image'] = $path;
        }

        return $data;
    }
}
