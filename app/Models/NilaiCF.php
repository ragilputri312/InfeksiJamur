<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiCF extends Model
{
    use HasFactory;

    protected $table = 'tblnilaicf';
    protected $fillable = ['kode_gejala', 'kode_penyakit', 'mb', 'md']; // Kolom yang dapat diisi
    public $timestamps = true;
}
