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
        Schema::table('ds_diagnosis', function (Blueprint $table) {
            // Make severity_label nullable
            $table->enum('severity_label', ['Tidak','Ringan','Sedang','Berat'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ds_diagnosis', function (Blueprint $table) {
            // Revert to not nullable
            $table->enum('severity_label', ['Tidak','Ringan','Sedang','Berat'])->nullable(false)->change();
        });
    }
};
