<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblIntervalcfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblintervalcf', function (Blueprint $table) {
            $table->id(); // id (auto-increment, bigint)
            $table->string('kondisi', 255); // kondisi (varchar)
            $table->double('nilai', 8, 2); // nilai (double)
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
        Schema::dropIfExists('tblintervalcf');
    }
}
