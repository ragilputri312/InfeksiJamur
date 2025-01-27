<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'tblpenyakit'; // Nama tabel yang digunakan
    protected $fillable = ['kode_penyakit', 'penyakit']; // Kolom yang dapat diisi
    public $timestamps = true; // Untuk otomatis mengatur created_at dan updated_at
}
