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
        Schema::create('ds_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('penyakit_id')->nullable();
            $table->decimal('belief_top', 5, 4)->nullable();
            $table->enum('severity_label', ['Tidak', 'Ringan', 'Sedang', 'Berat'])->nullable();
            $table->decimal('conflict_k', 6, 5)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('penyakit_id');
            $table->index('created_at');
        });

        Schema::table('ds_diagnosis', function (Blueprint $table) {
            if (Schema::hasTable('users')) {
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            }
            $table->foreign('penyakit_id')->references('id')->on('tblpenyakit')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ds_diagnosis');
    }
};
