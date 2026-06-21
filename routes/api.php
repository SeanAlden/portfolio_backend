<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\PersonalInfoController;
use App\Http\Controllers\Api\SkillCategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public Route untuk login Admin
Route::post('/login', [AuthController::class, 'login']);

// Protected Route (Hanya bisa diakses jika membawa Bearer Token yang valid)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Public Route (Bisa diakses dari form Next.js tanpa login)
Route::post('/contact', [ContactController::class, 'store']);

Route::get('/educations', [EducationController::class, 'index']);
Route::get('/skill-categories', [SkillCategoryController::class, 'index']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/experiences', [ExperienceController::class, 'index']);
Route::get('/organizations', [OrganizationController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);

// Protected Admin Routes (Harus membawa Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'index']); // History semua pesan
    Route::get('/admin/contacts/{id}', [ContactController::class, 'show']); // Baca detail pesan

    Route::apiResource('/admin/educations', EducationController::class);
    Route::apiResource('/admin/skill-categories', SkillCategoryController::class);
    Route::apiResource('/admin/skills', SkillController::class);
    Route::apiResource('/admin/experiences', ExperienceController::class);
    Route::apiResource('/admin/personal-infos', PersonalInfoController::class);
    Route::apiResource('/admin/organizations', OrganizationController::class);
    Route::apiResource('/admin/projects', ProjectController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
    // Tambahkan baris ini:
    Route::post('/user/update', [AuthController::class, 'updateProfile']);
});
