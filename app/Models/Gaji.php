<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';

    protected $fillable = [
        'id_karyawan',
        'gaji_pokok',
        'tunjangan',
        'total_gaji',
        'tanggal_gaji',
    ];
}
