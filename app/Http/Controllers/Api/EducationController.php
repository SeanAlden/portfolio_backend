<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\EducationService;
use App\Http\Controllers\Controller;
use App\Http\Resources\EducationResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Education\StoreEducationRequest;
use App\Http\Requests\Education\UpdateEducationRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EducationController extends Controller
{
    public function __construct(
        protected EducationService $educationService
    ) {}

    /**
     * GET /api/admin/educations
     */
    public function index(): AnonymousResourceCollection
    {
        $educations = $this->educationService->getAllEducations();
        
        // Return menggunakan Resource Collection
        return EducationResource::collection($educations);
    }

    /**
     * POST /api/admin/educations
     */
    public function store(StoreEducationRequest $request): JsonResponse
    {
        $education = $this->educationService->createEducation($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data edukasi berhasil ditambahkan.',
            'data' => new EducationResource($education)
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/admin/educations/{id}
     */
    public function show(int $id): JsonResponse
    {
        $education = $this->educationService->getEducationById($id);

        return response()->json([
            'status' => 'success',
            'data' => new EducationResource($education)
        ], Response::HTTP_OK);
    }

    /**
     * PUT/PATCH /api/admin/educations/{id}
     */
    public function update(UpdateEducationRequest $request, int $id): JsonResponse
    {
        $education = $this->educationService->updateEducation($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data edukasi berhasil diperbarui.',
            'data' => new EducationResource($education)
        ], Response::HTTP_OK);
    }

    /**
     * DELETE /api/admin/educations/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->educationService->deleteEducation($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data edukasi berhasil dihapus.'
        ], Response::HTTP_OK);
    }
}
