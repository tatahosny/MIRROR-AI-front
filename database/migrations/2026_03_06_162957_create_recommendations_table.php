<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analysis_id')->constrained('skin_analyses')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('usage_id')->constrained('product_usage')->onDelete('cascade');
            
            $table->decimal('match_score', 3, 2)->nullable();
            $table->integer('rank')->nullable();
            
            $table->boolean('was_shown')->default(false);
            $table->boolean('user_clicked')->default(false);
            $table->timestamps();

            $table->index(['analysis_id', 'rank']);
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
