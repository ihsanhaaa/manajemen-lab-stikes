@extends('layouts.app')

@section('title')
    Manajemen Obat
@endsection

@section('content')
    @push('css-plugins')
        <!-- DataTables -->
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        
        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <body data-topbar="dark">
    
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            @include('components.navbar')

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Success!</strong> {{ $message }}.
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                @foreach ($errors->all() as $error)
                                    <strong>{{ $error }}</strong><br>
                                @endforeach
                            </div>
                        @endif

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah Data Obat
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Obat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('data-obat.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="kode_obat" class="form-label">Kode Obat</label>
                                                <input type="text"
                                                    class="form-control @error('kode_obat') is-invalid @enderror" id="kode_obat"
                                                    name="kode_obat" value="{{ old('kode_obat') }}" required>

                                                @error('kode_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_obat" class="form-label">Nama Obat</label>
                                                <input type="text"
                                                    class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat"
                                                    name="nama_obat" value="{{ old('nama_obat') }}" required>

                                                @error('nama_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="jenis_obat" class="form-label">Jenis Obat</label>
                                                <select class="form-control @error('jenis_obat') is-invalid @enderror" id="jenis_obat" name="jenis_obat">
                                                    <option value="">-- Pilih Jenis Obat --</option>
                                                    <option value="Cair">Cair</option>
                                                    <option value="Padat">Padat</option>
                                                </select>
                                            
                                                @error('jenis_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="kekuatan_obat" class="form-label">Kekuatan Obat</label>
                                                <input type="text"
                                                    class="form-control @error('kekuatan_obat') is-invalid @enderror" id="kekuatan_obat"
                                                    name="kekuatan_obat">

                                                @error('kekuatan_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="kemasan_obat" class="form-label">Kemasan Obat</label>
                                                <select class="form-control @error('kemasan_obat') is-invalid @enderror" id="kemasan_obat" name="kemasan_obat" required>
                                                    <option value="">-- Pilih Kemasan Obat --</option>
                                                    @foreach($kemasans as $kemasan)
                                                        <option value="{{ $kemasan->id }}">{{ $kemasan->nama_kemasan }}</option>
                                                    @endforeach
                                                </select>
                                            
                                                @error('kemasan_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="bentuk_sediaan" class="form-label">Bentuk Sediaan</label>
                                                <select class="form-control @error('bentuk_sediaan') is-invalid @enderror" id="bentuk_sediaan" name="bentuk_sediaan" required>
                                                    <option value="">-- Pilih Bentuk Sediaan --</option>
                                                    @foreach($bentukSediaans as $bentukSediaan)
                                                        <option value="{{ $bentukSediaan->id }}">{{ $bentukSediaan->nama_bentuk_sediaan }}</option>
                                                    @endforeach
                                                </select>
                                            
                                                @error('bentuk_sediaan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="exp_obat" class="form-label">Expired Obat</label>
                                                <input type="date"
                                                    class="form-control @error('exp_obat') is-invalid @enderror" id="exp_obat"
                                                    name="exp_obat" value="{{ old('exp_obat') }}">

                                                @error('exp_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <select class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan">
                                                    <option value="">-- Pilih Satuan --</option>
                                                    @foreach($satuans as $satuan)
                                                        <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                                                    @endforeach
                                                </select>
                                            
                                                @error('satuan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                {{-- hanya satu foto --}}
                                                <label for="foto_obat" class="form-label">Foto</label>
                                                <input type="file"
                                                    class="form-control @error('foto_obat') is-invalid @enderror" id="foto_obat"
                                                    name="foto_obat">

                                                @error('foto_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="stok_awal" class="form-label">Stok Awal</label>
                                                <input type="number"
                                                    class="form-control @error('stok_awal') is-invalid @enderror" id="stok_awal"
                                                    name="stok_awal" required value="{{ old('stok_awal') }}">

                                                @error('stok_awal')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Data Obat</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item active">Data Obat</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kode Obat</th>
                                                    <th>Nama obat</th>
                                                    <th>Jenis Obat</th>
                                                    <th>Kekuatan Obat</th>
                                                    <th>Barang Masuk</th>
                                                    <th>Barang Keluar</th>
                                                    <th>Stok Akhir</th>
                                                    {{-- <th>Expired</th> --}}
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                @foreach($obats as $key => $obat)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>{{ $obat->kode_obat }}</td>
                                                        <td>{{ $obat->nama_obat }}</td>

                                                        <td>{{ $obat->jenis_obat }}</td>
                                                        <td>{{ $obat->kekuatan_obat }}</td>

                                                        {{-- <td>{{ $obat->stok_obat }}</td> --}}
                                                        <td>{{ $obat->stokMasuks->sum('jumlah_masuk') }}</td>
                                                        <td>{{ $obat->stokKeluars->sum('jumlah_pemakaian') }}</td>
                                                        <td>
                                                            @if ($obat->sisa_obat == 0)
                                                                <span class="badge badge-pill bg-danger" style="font-size: 15px;">
                                                                    {{ $obat->sisa_obat }}
                                                                </span>
                                                            @elseif($obat->sisa_obat >= 1 && $obat->sisa_obat <= 5)
                                                                <span class="badge badge-pill bg-warning" style="font-size: 15px;">
                                                                    {{ $obat->sisa_obat }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-pill bg-success" style="font-size: 15px;">
                                                                    {{ $obat->sisa_obat }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        {{-- <td>{{ $obat->exp_obat }}</td> --}}
                                                        <td>
                                                            <a href="{{ route('data-obat.show', $obat->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat Detail</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                {{-- @include('components.footer') --}}
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </body>
</html>


    @push('javascript-plugins')

        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="≈{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    @endpush
@endsection