<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\PersonalInfoService;
use App\Http\Resources\PersonalInfoResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\PersonalInfo\StorePersonalInfoRequest;
use App\Http\Requests\PersonalInfo\UpdatePersonalInfoRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PersonalInfoController extends Controller
{
    public function __construct(
        protected PersonalInfoService $personalInfoService
    ) {}

    /**
     * GET /api/admin/personal-infos
     */
    public function index(): AnonymousResourceCollection
    {
        $infos = $this->personalInfoService->getAllInfos();
        
        return PersonalInfoResource::collection($infos);
    }

    /**
     * POST /api/admin/personal-infos
     */
    public function store(StorePersonalInfoRequest $request): JsonResponse
    {
        // $request->validated() sudah mengambil data teks dan file sekaligus
        $info = $this->personalInfoService->createInfo($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Informasi personal berhasil ditambahkan.',
            'data' => new PersonalInfoResource($info)
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/admin/personal-infos/{id}
     */
    public function show(int $id): JsonResponse
    {
        $info = $this->personalInfoService->getInfoById($id);

        return response()->json([
            'status' => 'success',
            'data' => new PersonalInfoResource($info)
        ], Response::HTTP_OK);
    }

    /**
     * PUT/PATCH /api/admin/personal-infos/{id}
     * Catatan: Untuk upload file via Postman/Frontend, gunakan method POST 
     * lalu tambahkan '_method' => 'PUT' di form-data.
     */
    public function update(UpdatePersonalInfoRequest $request, int $id): JsonResponse
    {
        $info = $this->personalInfoService->updateInfo($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Informasi personal berhasil diperbarui.',
            'data' => new PersonalInfoResource($info)
        ], Response::HTTP_OK);
    }

    /**
     * DELETE /api/admin/personal-infos/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->personalInfoService->deleteInfo($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Informasi personal berhasil dihapus.'
        ], Response::HTTP_OK);
    }
}
