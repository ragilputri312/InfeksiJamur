<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbldiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbldiagnosis', function (Blueprint $table) {
            $table->id(); // id (auto-increment, bigint)
            $table->string('diagnosis_id', 255); // diagnosis_id (char)
            $table->longText('data_diagnosis'); // data_diagnosis (longtext)
            $table->longText('kondisi'); // kondisi (longtext)
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
        Schema::dropIfExists('tbldiagnosis');
    }
}
