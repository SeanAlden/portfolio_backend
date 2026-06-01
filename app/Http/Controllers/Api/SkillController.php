<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\SkillService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;
use App\Http\Requests\Skill\StoreSkillRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Skill\UpdateSkillRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SkillController extends Controller
{
    public function __construct(
        protected SkillService $skillService
    ) {}

    /**
     * GET /api/admin/skills
     */
    public function index(): AnonymousResourceCollection
    {
        $skills = $this->skillService->getAllSkills();
        
        return SkillResource::collection($skills);
    }

    /**
     * POST /api/admin/skills
     */
    public function store(StoreSkillRequest $request): JsonResponse
    {
        $skill = $this->skillService->createSkill($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Skill berhasil ditambahkan.',
            'data' => new SkillResource($skill)
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/admin/skills/{id}
     */
    public function show(int $id): JsonResponse
    {
        $skill = $this->skillService->getSkillById($id);

        return response()->json([
            'status' => 'success',
            'data' => new SkillResource($skill)
        ], Response::HTTP_OK);
    }

    /**
     * PUT/PATCH /api/admin/skills/{id}
     */
    public function update(UpdateSkillRequest $request, int $id): JsonResponse
    {
        $skill = $this->skillService->updateSkill($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Skill berhasil diperbarui.',
            'data' => new SkillResource($skill)
        ], Response::HTTP_OK);
    }

    /**
     * DELETE /api/admin/skills/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->skillService->deleteSkill($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Skill berhasil dihapus.'
        ], Response::HTTP_OK);
    }
}
