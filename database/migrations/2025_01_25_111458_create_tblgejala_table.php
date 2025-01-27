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
        Schema::create('tblgejala', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->char('kode_gejala', 255); // Kode gejala yang menarik dan unik
            $table->string('gejala', 255); // Deskripsi gejala yang informatif
            $table->timestamps(); // Untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblgejala');
    }
};
