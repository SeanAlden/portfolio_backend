<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    /**
     * Menyimpan pesan baru ke database.
     */
    public function storeNewMessage(array $validatedData): ContactMessage
    {
        return ContactMessage::create($validatedData);
    }

    /**
     * Mengambil daftar semua pesan masuk untuk halaman history Admin.
     * Pesan terbaru akan tampil paling atas.
     */
    public function getAllMessages(): Collection
    {
        return ContactMessage::latest()->get();
    }

    /**
     * Membaca detail 1 pesan khusus berdasarkan ID,
     * dan otomatis mengubah statusnya menjadi "Telah Dibaca" (is_read = true).
     */
    public function readMessage(int $id): ContactMessage
    {
        $message = ContactMessage::findOrFail($id);

        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return $message;
    }
}
