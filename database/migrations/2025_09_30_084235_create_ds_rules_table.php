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
        Schema::create('ds_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penyakit_id');
            $table->unsignedBigInteger('gejala_id');
            $table->decimal('mass_support', 4, 3);
            $table->decimal('mass_ignorance', 4, 3);
            $table->timestamps();

            $table->unique(['penyakit_id', 'gejala_id']);
            $table->index('penyakit_id');
            $table->index('gejala_id');
        });

        Schema::table('ds_rules', function (Blueprint $table) {
            $table->foreign('penyakit_id')->references('id')->on('tblpenyakit')->onDelete('cascade');
            $table->foreign('gejala_id')->references('id')->on('tblgejala')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ds_rules');
    }
};
