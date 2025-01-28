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
        Schema::table('tbldiagnosis', function (Blueprint $table) {
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->foreign('id_akun')->references('id')->on('tblakun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbldiagnosis', function (Blueprint $table) {
            $table->dropForeign(['id_akun']);
            $table->dropColumn('id_akun');
        });
    }
};
