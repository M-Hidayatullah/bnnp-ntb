@extends('layouts.app', ['title' => 'Tambah Karyawan'])

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-users"></i> TAMBAH KARYAWAN</h6>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.karyawan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NAMA LENGKAP KARYAWAN</label>
                                        <input type="text" name="nama" value="{{ old('nama') }}"
                                               placeholder="Masukkan Nama Karyawan"
                                               class="form-control @error('nama') is-invalid @enderror">

                                        @error('nama')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIP</label>
                                        <input type="number" name="nip" id="nip" value="{{ old('nip') }}"
                                               placeholder="Masukkan NIP"
                                               class="form-control @error('nip') is-invalid @enderror">

                                        @error('nip')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>JABATAN</label>
                                        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}"
                                               placeholder="Masukkan Jabatan"
                                               class="form-control @error('jabatan') is-invalid @enderror">

                                        @error('jabatan')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>HAK CUTI</label>
                                        <input type="number" name="hak_cuti" id="hak_cuti" value="{{ old('hak_cuti') }}"
                                               placeholder="Hak Cuti"
                                               class="form-control @error('hak_cuti') is-invalid @enderror">

                                        @error('hak_cuti')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>JUMLAH CUTI</label>
                                        <input type="number" name="jumlah_cuti" id="jumlah_cuti" value="{{ old('jumlah_cuti') }}"
                                               placeholder="Jumlah Cuti"
                                               class="form-control @error('jumlah_cuti') is-invalid @enderror">

                                        @error('jumlah_cuti')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>KETERANGAN</label>
                                        <select name="keterangan" id="keterangan"
                                                class="form-control @error('keterangan') is-invalid @enderror">
                                            <option value="" disabled selected>--Pilih--</option>
                                            @foreach ($data['keterangan'] as $item)
                                                <option
                                                    {{ old('keterangan') == $item ? 'selected' : '' }} value="{{ $item }}"> {{ str_replace('_', ' ', $item) }} </option>
                                            @endforeach
                                        </select>
                                        @error('keterangan')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>UPLOAD FILE GAJI BERKALA</label><br>
                                        <small class="text-danger">file harus pdf dan word ukurannya 2mb</small>
                                        <input type="file" name="file_kgb" id="file_kgb" value="{{ old('file_kgb') }}"
                                               class="form-control @error('file_kgb') is-invalid @enderror">

                                        @error('file_kgb')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                SIMPAN</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
