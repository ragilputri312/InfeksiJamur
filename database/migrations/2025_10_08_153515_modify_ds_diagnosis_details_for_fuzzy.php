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
        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            $table->enum('kemunculan', ['Sangat Jarang', 'Kadang-Kadang', 'Sering'])->nullable()->after('jawaban');
            $table->decimal('fuzzy_densitas', 5, 4)->nullable()->after('kemunculan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            $table->dropColumn(['kemunculan', 'fuzzy_densitas']);
        });
    }
};
