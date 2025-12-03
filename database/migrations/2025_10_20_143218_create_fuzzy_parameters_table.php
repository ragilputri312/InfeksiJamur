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
        Schema::create('fuzzy_parameters', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['kemunculan', 'keunikan']); // Tipe parameter
            $table->string('label'); // Label seperti "Sangat Jarang", "Rendah", dll
            $table->decimal('nilai', 3, 2); // Nilai numerik (0.0 - 1.0)
            $table->string('deskripsi')->nullable(); // Deskripsi parameter
            $table->integer('urutan')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index untuk performa
            $table->index(['tipe', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzy_parameters');
    }
};
