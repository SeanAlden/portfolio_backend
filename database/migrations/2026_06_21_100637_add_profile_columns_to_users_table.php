<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom dengan tipe nullable (boleh kosong)
            $table->string('role')->nullable()->after('name');
            $table->string('image')->nullable()->after('email');
            $table->text('description')->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'image', 'description']);
        });
    }
};
