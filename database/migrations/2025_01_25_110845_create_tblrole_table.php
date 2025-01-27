<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblroleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblrole', function (Blueprint $table) {
            $table->id('id_role'); // Primary key
            $table->string('nama'); // Role name
            $table->timestamps();
        });

        // Insert default roles
        DB::table('tblrole')->insert([
            ['id_role' => 1, 'nama' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 2, 'nama' => 'user', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblrole');
    }
}
