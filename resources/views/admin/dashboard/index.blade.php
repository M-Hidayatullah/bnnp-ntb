@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->


        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->

            <div class="col-md-12">
                <div class="card border-0 shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header text-center">
                        <h4 class="m-0 font-weight-bold">Selamat Datang {{ auth()->user()->name }} di BNNP NTB</h4>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h6 class="text-center font-weight-bold">Oleh Titin Yustika & Anna Mawaddah</h6>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card border-0 shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header text-center">
                        <h6 class="m-0 font-weight-bold">Data Karyawan Aktif</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h5 class="text-center">{{ $karyawan }}</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
