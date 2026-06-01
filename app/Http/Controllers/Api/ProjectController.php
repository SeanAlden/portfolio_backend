<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService
    ) {}

    /**
     * GET /api/admin/projects
     */
    public function index(): AnonymousResourceCollection
    {
        $projects = $this->projectService->getAllProjects();
        
        return ProjectResource::collection($projects);
    }

    /**
     * POST /api/admin/projects
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek berhasil ditambahkan.',
            'data' => new ProjectResource($project)
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/admin/projects/{id}
     */
    public function show(int $id): JsonResponse
    {
        $project = $this->projectService->getProjectById($id);

        return response()->json([
            'status' => 'success',
            'data' => new ProjectResource($project)
        ], Response::HTTP_OK);
    }

    /**
     * PUT/PATCH /api/admin/projects/{id}
     */
    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        $project = $this->projectService->updateProject($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek berhasil diperbarui.',
            'data' => new ProjectResource($project)
        ], Response::HTTP_OK);
    }

    /**
     * DELETE /api/admin/projects/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->projectService->deleteProject($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Proyek berhasil dihapus.'
        ], Response::HTTP_OK);
    }
}
