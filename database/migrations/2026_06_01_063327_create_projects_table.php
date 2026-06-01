<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('education_id')->nullable()->constrained('educations')->cascadeOnDelete();
            $table->string('name');
            $table->text('desc');
            $table->json('tech'); // Array of strings (e.g. ["Laravel", "Vue"])
            $table->json('github_urls'); // Array of objects (e.g. [{"label": "API", "url": "..."}])
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
