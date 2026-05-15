<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('suitable_for_skin_types', 255)->nullable();
            $table->string('suitable_for_concerns', 255)->nullable();
            $table->string('usage_frequency', 100)->nullable();
            $table->string('usage_time', 50)->nullable();
            $table->text('how_to_use')->nullable();
            $table->string('amount_to_use', 100)->nullable();
            $table->text('warnings')->nullable();
            $table->integer('priority')->default(5);
            $table->boolean('is_essential')->default(true);
            $table->timestamps();

            $table->index(['suitable_for_skin_types', 'suitable_for_concerns'], 'skin_type_concern_index');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_usage');
    }
};
