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
        Schema::table('skin_analyses', function (Blueprint $table) {
            $table->boolean('sensitive_barrier')->default(false)->after('detected_skin_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skin_analyses', function (Blueprint $table) {
            $table->dropColumn('sensitive_barrier');
        });
    }
};
