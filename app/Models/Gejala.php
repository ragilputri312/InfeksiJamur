<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'tblgejala'; // Nama tabel yang digunakan
    protected $fillable = ['kode_gejala', 'gejala']; // Kolom yang dapat diisi
    public $timestamps = true; // Untuk otomatis mengatur created_at dan updated_at
}
