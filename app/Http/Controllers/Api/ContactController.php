<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Contact\StoreMessageRequest;

class ContactController extends Controller
{
    // Dependency Injection dari ContactService
    public function __construct(
        protected ContactService $contactService
    ) {}

    /**
     * [ENDPOINT PUBLIC]
     * Menyimpan pesan dari pengunjung web.
     */
    public function store(StoreMessageRequest $request): JsonResponse
    {
        $this->contactService->storeNewMessage($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dikirim! Saya akan segera menghubungi Anda.',
        ], Response::HTTP_CREATED);
    }

    /**
     * [ENDPOINT ADMIN]
     * Menampilkan semua history pesan masuk.
     */
    public function index(): JsonResponse
    {
        $messages = $this->contactService->getAllMessages();

        return response()->json([
            'status' => 'success',
            'data' => $messages,
        ], Response::HTTP_OK);
    }

    /**
     * [ENDPOINT ADMIN]
     * Melihat isi detail 1 pesan & menandai sudah dibaca.
     */
    public function show(int $id): JsonResponse
    {
        $message = $this->contactService->readMessage($id);

        return response()->json([
            'status' => 'success',
            'data' => $message,
        ], Response::HTTP_OK);
    }
}
