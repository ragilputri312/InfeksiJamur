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
        Schema::table('tblpenyakit', function (Blueprint $table) {
            $table->text('penangan')->nullable()->after('penyakit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tblpenyakit', function (Blueprint $table) {
            $table->dropColumn('penangan');
        });
    }
};
