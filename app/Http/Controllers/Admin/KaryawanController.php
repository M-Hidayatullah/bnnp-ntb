<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::latest()->when(request()->q, function($karyawans) {
            $karyawans = $karyawans->where('nama', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        $keterangan = Collection::empty();
        $keterangan->add('Aktif');
        $keterangan->add('Tidak Aktif');

        $data = Collection::empty();
        $data->put('keterangan', $keterangan);

        return view('admin.karyawan.create', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'       => 'required',
            'nip'      => 'required',
            'jabatan'   => 'required',
            'hak_cuti'   => 'required',
            'jumlah_cuti'   => 'required',
            'keterangan'   => 'required',
        ]);

        $sisa_cuti = $request->hak_cuti - $request->jumlah_cuti ;

        $karyawan = Karyawan::create([
            'nama'       => $request->nama,
            'nip'        => $request->nip,
            'jabatan'    => $request->jabatan,
            'hak_cuti'   => $request->hak_cuti,
            'jumlah_cuti'=> $request->jumlah_cuti,
            'sisa_cuti'  => $sisa_cuti,
            'keterangan' => $request->keterangan,
        ]);

        if($karyawan){
            //redirect dengan pesan sukses
            return redirect()->route('admin.karyawan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.karyawan.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(Karyawan $karyawan)
    {
        $keterangan = Collection::empty();
        $keterangan->add('Aktif');
        $keterangan->add('Tidak Aktif');

        $data = Collection::empty();
        $data->put('keterangan', $keterangan);

        return view('admin.karyawan.edit', compact('karyawan', 'data', ));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $this->validate($request, [
            'nama'       => 'required',
            'nip'      => 'required',
            'jabatan'   => 'required',
            'hak_cuti'   => 'required',
            'jumlah_cuti'   => 'required',
            'keterangan'   => 'required',
        ]);

        $sisa_cuti = $request->hak_cuti - $request->jumlah_cuti ;

        $karyawan = Karyawan::findOrFail($karyawan->id);
        $karyawan->update([
            'nama'       => $request->nama,
            'nip'        => $request->nip,
            'jabatan'    => $request->jabatan,
            'hak_cuti'   => $request->hak_cuti,
            'jumlah_cuti'=> $request->jumlah_cuti,
            'sisa_cuti'  => $sisa_cuti,
            'keterangan' => $request->keterangan,
        ]);

        if($karyawan){
            //redirect dengan pesan sukses
            return redirect()->route('admin.karyawan.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.karyawan.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        if($karyawan){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
