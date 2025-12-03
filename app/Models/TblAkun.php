<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblAkun extends Model
{
    use HasFactory;

    protected $table = 'tblakun';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'sandi',
        'alamat',
        'jk',
        'id_role'
    ];

    protected $guarded = ['id_akun'];

}
