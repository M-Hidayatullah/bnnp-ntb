<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'hak_cuti',
        'jumlah_cuti',
        'sisa_cuti',
        'keterangan'
    ];
}
