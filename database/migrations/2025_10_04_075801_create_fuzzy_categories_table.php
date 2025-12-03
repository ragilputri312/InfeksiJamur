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
        Schema::create('fuzzy_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->decimal('min_value', 5, 2); // nilai minimum untuk kategori
            $table->decimal('max_value', 5, 2); // nilai maksimum untuk kategori
            $table->string('label'); // label seperti "Ringan", "Sedang", "Berat"
            $table->string('color', 20)->default('secondary'); // warna badge
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzy_categories');
    }
};
