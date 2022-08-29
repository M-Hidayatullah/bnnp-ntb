<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $karyawan = Karyawan::where('keterangan', '=', 'Aktif')->count();

        return view('admin.dashboard.index', [
            'karyawan' => $karyawan,
        ]);
    }
}
