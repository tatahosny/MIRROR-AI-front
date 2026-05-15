<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analysis_comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('session_id_1')->constrained('skin_sessions')->onDelete('cascade');
            $table->foreignId('session_id_2')->constrained('skin_sessions')->onDelete('cascade');
            $table->integer('acne_improvement')->nullable(); // percentage change
            $table->integer('hydration_improvement')->nullable();
            $table->integer('pigmentation_improvement')->nullable();
            $table->integer('sensitivity_improvement')->nullable();
            $table->integer('overall_improvement')->nullable(); // 0-100 percentage
            $table->string('trend_direction')->nullable(); // up, down, stable
            $table->json('comparison_summary')->nullable();
            $table->text('ai_generated_summary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analysis_comparisons');
    }
};
