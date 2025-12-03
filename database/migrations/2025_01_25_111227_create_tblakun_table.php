<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblakunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblakun', function (Blueprint $table) {
            $table->id('id_akun'); // Primary key
            $table->string('nama'); // Nama pengguna
            $table->string('telepon')->unique(); // Nomor telepon utama untuk login
            $table->string('email')->nullable()->unique(); // Email (opsional)
            $table->string('sandi'); // Kata sandi
            $table->string('alamat'); // Alamat pengguna
            $table->string('jk'); // Jenis kelamin (Laki-laki / Perempuan)
            $table->unsignedBigInteger('id_role'); // Relasi ke tabel tblrole
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_role')->references('id_role')->on('tblrole')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblakun');
    }
}
