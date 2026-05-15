<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skin_analyses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('image_path', 500);
            
            $table->string('detected_skin_type', 50)->nullable();
            $table->text('detected_concerns')->nullable();
            $table->boolean('sensitive_barrier')->nullable();
            $table->text('summary')->nullable();
            $table->json('global_scores')->nullable();
            $table->text('user_answers')->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index('detected_skin_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skin_analyses');
    }
};
