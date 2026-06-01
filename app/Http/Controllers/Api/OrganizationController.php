<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\OrganizationService;
use App\Http\Resources\OrganizationResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $organizationService
    ) {}

    /**
     * GET /api/admin/organizations
     */
    public function index(): AnonymousResourceCollection
    {
        $organizations = $this->organizationService->getAllOrganizations();
        
        return OrganizationResource::collection($organizations);
    }

    /**
     * POST /api/admin/organizations
     */
    public function store(StoreOrganizationRequest $request): JsonResponse
    {
        $organization = $this->organizationService->createOrganization($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data organisasi berhasil ditambahkan.',
            'data' => new OrganizationResource($organization)
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/admin/organizations/{id}
     */
    public function show(int $id): JsonResponse
    {
        $organization = $this->organizationService->getOrganizationById($id);

        return response()->json([
            'status' => 'success',
            'data' => new OrganizationResource($organization)
        ], Response::HTTP_OK);
    }

    /**
     * PUT/PATCH /api/admin/organizations/{id}
     */
    public function update(UpdateOrganizationRequest $request, int $id): JsonResponse
    {
        $organization = $this->organizationService->updateOrganization($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data organisasi berhasil diperbarui.',
            'data' => new OrganizationResource($organization)
        ], Response::HTTP_OK);
    }

    /**
     * DELETE /api/admin/organizations/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->organizationService->deleteOrganization($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data organisasi berhasil dihapus.'
        ], Response::HTTP_OK);
    }
}
