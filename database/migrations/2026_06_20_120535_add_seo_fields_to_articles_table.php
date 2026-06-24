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
        Schema::table('articles', function (Blueprint $table) {
            $table->string('primary_keyword')->nullable()->after('meta_description');
            $table->json('secondary_keywords')->nullable()->after('primary_keyword');
            $table->text('search_intent')->nullable()->after('secondary_keywords');
            $table->text('target_audience')->nullable()->after('search_intent');
            $table->string('reading_time')->nullable()->after('target_audience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['primary_keyword', 'secondary_keywords', 'search_intent', 'target_audience', 'reading_time']);
        });
    }
};
