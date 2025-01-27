<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblNilaiCfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblnilaicf', function (Blueprint $table) {
            $table->id(); // id (auto-increment, bigint)
            $table->char('kode_gejala', 255); // kode_gejala (char)
            $table->char('kode_penyakit', 255); // kode_penyakit (char)
            $table->double('mb', 8, 2); // mb (double)
            $table->double('md', 8, 2); // md (double)
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblnilaicf');
    }
}
