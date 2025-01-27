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
        Schema::create('tblpenyakit', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->char('kode_penyakit', 255); // Kode unik penyakit
            $table->string('penyakit', 255); // Nama/deskripsi penyakit
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblpenyakit');
    }
};
