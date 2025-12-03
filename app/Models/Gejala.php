<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'tblgejala'; // Nama tabel yang digunakan
    protected $fillable = ['kode_gejala', 'gejala', 'pertanyaan', 'is_active', 'urutan']; // Kolom yang dapat diisi
    public $timestamps = true; // Untuk otomatis mengatur created_at dan updated_at

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];
}
