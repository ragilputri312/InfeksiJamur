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
        Schema::create('ds_diagnosis_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ds_diagnosis_id');
            $table->unsignedBigInteger('gejala_id')->nullable();
            $table->enum('jawaban', ['Ya', 'Tidak']);
            $table->decimal('mass_used_support', 4, 3)->nullable();
            $table->decimal('mass_used_ignorance', 4, 3)->nullable();
            $table->timestamps();

            $table->index('ds_diagnosis_id');
            $table->index('gejala_id');
        });

        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            $table->foreign('ds_diagnosis_id')->references('id')->on('ds_diagnosis')->onDelete('cascade');
            $table->foreign('gejala_id')->references('id')->on('tblgejala')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ds_diagnosis_details');
    }
};
