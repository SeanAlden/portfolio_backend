<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\SkillCategoryService;
use App\Http\Resources\SkillCategoryResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\SkillCategory\StoreSkillCategoryRequest;
use App\Http\Requests\SkillCategory\UpdateSkillCategoryRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SkillCategoryController extends Controller
{
    public function __construct(
        protected SkillCategoryService $skillCategoryService
    ) {}

    /**
     * GET /api/admin/skill-categories
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = $this->skillCategoryService->getAllCategories();
        
        return SkillCategoryResource::collection($categories);
    }

    /**
     * POST /api/admin/skill-categories
     */
    public function store(StoreSkillCategoryRequest $request): JsonResponse
    {
        $category = $this->skillCategoryService->createCategory($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori skill berhasil ditambahkan.',
            'data' => new SkillCategoryResource($category)
        ], Response::HTTP_CREATED);
    }

    /**
     * GET /api/admin/skill-categories/{id}
     */
    public function show(int $id): JsonResponse
    {
        $category = $this->skillCategoryService->getCategoryById($id);

        return response()->json([
            'status' => 'success',
            'data' => new SkillCategoryResource($category)
        ], Response::HTTP_OK);
    }

    /**
     * PUT/PATCH /api/admin/skill-categories/{id}
     */
    public function update(UpdateSkillCategoryRequest $request, int $id): JsonResponse
    {
        $category = $this->skillCategoryService->updateCategory($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori skill berhasil diperbarui.',
            'data' => new SkillCategoryResource($category)
        ], Response::HTTP_OK);
    }

    /**
     * DELETE /api/admin/skill-categories/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->skillCategoryService->deleteCategory($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori skill beserta isinya berhasil dihapus.'
        ], Response::HTTP_OK);
    }
}
