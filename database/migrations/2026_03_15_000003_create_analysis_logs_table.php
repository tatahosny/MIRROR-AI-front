<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analysis_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('skin_sessions')->onDelete('cascade');
            $table->string('step'); // upload, validation, gemini_processing, storage, completion
            $table->string('status'); // started, in_progress, completed, failed
            $table->json('meta')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analysis_logs');
    }
};
