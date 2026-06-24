<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('icon')->nullable();
            $table->string('year', 10)->nullable();
            $table->string('url')->nullable();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('role_ar')->nullable();
            $table->string('role_en')->nullable();
            $table->string('desc_ar')->nullable();
            $table->string('desc_en')->nullable();
            $table->text('overview_ar')->nullable();
            $table->text('overview_en')->nullable();
            $table->json('tags_ar')->nullable();
            $table->json('tags_en')->nullable();
            $table->json('highlights_ar')->nullable();
            $table->json('highlights_en')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
