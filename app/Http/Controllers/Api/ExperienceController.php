<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\ExperienceService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Experience\StoreExperienceRequest;
use App\Http\Requests\Experience\UpdateExperienceRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExperienceController extends Controller
{
    public function __construct(
        protected ExperienceService $experienceService
    ) {}

    /**
     * GET /api/admin/experiences
     */
    public function index(): AnonymousResourceCollection
    {
        $experiences = $this->experienceService->getAllExperiences();
        
        return ExperienceResource::collection($experiences);
    }

    /**
     * POST /api/admin/experiences
     */
    public function store(StoreExperienceRequest $request): JsonResponse
    {
        $experience = $this->experienceService->createExperience($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Pengalaman kerja berhasil ditambahkan.',
            'data' => new ExperienceResource($experience)
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/admin/experiences/{id}
     */
    public function show(int $id): JsonResponse
    {
        $experience = $this->experienceService->getExperienceById($id);

        return response()->json([
            'status' => 'success',
            'data' => new ExperienceResource($experience)
        ], Response::HTTP_OK);
    }

    /**
     * PUT/PATCH /api/admin/experiences/{id}
     */
    public function update(UpdateExperienceRequest $request, int $id): JsonResponse
    {
        $experience = $this->experienceService->updateExperience($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Pengalaman kerja berhasil diperbarui.',
            'data' => new ExperienceResource($experience)
        ], Response::HTTP_OK);
    }

    /**
     * DELETE /api/admin/experiences/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->experienceService->deleteExperience($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengalaman kerja berhasil dihapus.'
        ], Response::HTTP_OK);
    }
}
