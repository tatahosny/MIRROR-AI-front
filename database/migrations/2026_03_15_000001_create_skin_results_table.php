<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skin_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('skin_sessions')->onDelete('cascade');
            $table->string('image_path');
            $table->string('image_url')->nullable();
            $table->string('skin_type')->nullable(); // oily, dry, combination, normal, sensitive
            $table->integer('acne_score')->default(0); // 0-100
            $table->integer('hydration_score')->default(0); // 0-100
            $table->integer('pigmentation_score')->default(0); // 0-100
            $table->integer('sensitivity_score')->default(0); // 0-100
            $table->integer('overall_score')->default(0); // 0-100
            $table->json('recommendations')->nullable();
            $table->json('analysis_data')->nullable(); // Full Gemini API response
            $table->string('analysis_status')->default('pending'); // pending, processing, completed, failed
            $table->text('analysis_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skin_results');
    }
};
