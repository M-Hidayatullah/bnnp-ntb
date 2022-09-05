<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

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
            'file_kgb' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $file_kgb = $request->file('file_kgb');
        $namekgb = time() . "_" . $file_kgb->getClientOriginalName();
        $path = 'data/pdf';
        $file_kgb->move($path, $namekgb);

        $sisa_cuti = $request->hak_cuti - $request->jumlah_cuti ;

        $karyawan = Karyawan::create([
            'nama'       => $request->nama,
            'nip'        => $request->nip,
            'jabatan'    => $request->jabatan,
            'hak_cuti'   => $request->hak_cuti,
            'jumlah_cuti'=> $request->jumlah_cuti,
            'sisa_cuti'  => $sisa_cuti,
            'keterangan' => $request->keterangan,
            'file_kgb'   => $namekgb
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
            'file_kgb' => 'mimes:pdf,doc,docx|max:2048',
        ]);

        $sisa_cuti = $request->hak_cuti - $request->jumlah_cuti ;

        if($request->file('file_kgb') == "") {
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
        } else {
            $file_kgb = $request->file('file_kgb');
            $namekgb = time() . "_" . $file_kgb->getClientOriginalName();
            $path = 'data/pdf';
            $file_kgb->move($path, $namekgb);

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
                'file_kgb'   => $namekgb
            ]);
        }
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

        Storage::delete('data/pdf/'.$karyawan->file_kgb);

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

    public function download($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $myFile = public_path(). "/data/pdf/".$karyawan->file_kgb;
        $headers = ['Content-Type: application/pdf,doc,docx'];
        $newName = $karyawan->file_kgb;

        return response()->download($myFile, $newName, $headers);
    }
}
