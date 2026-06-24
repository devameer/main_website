<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->longText('body')->nullable();
            $table->longText('body_en')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('language', 2)->default('en'); // en | ar
            $table->string('cover_image')->nullable();
            $table->string('author')->default('Ameer Ahmad');
            $table->string('author_avatar')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->default('draft'); // published | draft | scheduled | archived
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
