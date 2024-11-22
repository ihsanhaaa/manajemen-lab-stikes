@extends('layouts.app')

@section('title')
    Data Bahan
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

                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Error!</strong> {{ $message }}.
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
                        <button type="button" class="btn btn-primary mb-3 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah Data Bahan
                        </button>

                        <a href="{{ route('laporan.obat.exportPDF') }}" class="btn btn-info mb-3 mx-1">
                            <i class="fas fa-download"></i> Download Laporan PDF
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Bahan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('data-bahan.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="kode_bahan" class="form-label">Kode Bahan <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('kode_bahan') is-invalid @enderror" id="kode_bahan"
                                                    name="kode_bahan" value="{{ old('kode_bahan') }}" required>

                                                @error('kode_bahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_bahan" class="form-label">Nama Bahan <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('nama_bahan') is-invalid @enderror" id="nama_bahan"
                                                    name="nama_bahan" value="{{ old('nama_bahan') }}" required>

                                                @error('nama_bahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="jenis_bahan" class="form-label">Jenis Bahan <span style="color: red">*</span> </label>
                                                <select class="form-control @error('jenis_bahan') is-invalid @enderror" id="jenis_bahan" name="jenis_bahan">
                                                    <option value="">-- Pilih Jenis Bahan --</option>
                                                    <option value="Cair">Cair</option>
                                                    <option value="Padat">Padat</option>
                                                </select>
                                            
                                                @error('jenis_bahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="formula" class="form-label">Formula</label>
                                                <input type="text"
                                                    class="form-control @error('formula') is-invalid @enderror" id="formula"
                                                    name="formula">

                                                @error('formula')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="exp_bahan" class="form-label">Expired Bahan</label>
                                                <input type="date"
                                                    class="form-control @error('exp_bahan') is-invalid @enderror" id="exp_bahan"
                                                    name="exp_bahan" value="{{ old('exp_bahan') }}">

                                                @error('exp_bahan')
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
                                                <label for="stok_bahan" class="form-label">Stok Bahan <span style="color: red">*</span> </label>
                                                <input type="number"
                                                    class="form-control @error('stok_bahan') is-invalid @enderror" id="stok_bahan"
                                                    name="stok_bahan" value="{{ old('stok_bahan') }}" required>

                                                @error('stok_bahan')
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
                                    <h4 class="mb-sm-0">Data Bahan ({{ $bahans->count() }})</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item active">Data Bahan</li>
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
                                                    <th>Kode Bahan</th>
                                                    <th>Nama Bahan</th>
                                                    <th>Formula</th>
                                                    <th>Bahan Masuk</th>
                                                    <th>Bahan Keluar</th>
                                                    <th>Stok</th>
                                                    <th>Expired</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                @foreach($bahans as $key => $bahan)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>{{ $bahan->kode_bahan }}</td>
                                                        <td>{{ $bahan->nama_bahan }}</td>
                                                        <td>{{ $bahan->formula }}</td>

                                                        {{-- <td>{{ $bahan->stok_obat }}</td> --}}
                                                        <td>{{ $bahan->bahanMasuks->sum('jumlah_masuk') }}</td>
                                                        <td>{{ $bahan->bahanKeluars->sum('jumlah_pemakaian') }}</td>
                                                        <td>
                                                            @if ($bahan->stok_bahan == 0)
                                                                <span class="badge badge-pill bg-danger" style="font-size: 15px;">
                                                                    {{ $bahan->stok_bahan }}
                                                                </span>
                                                            @elseif($bahan->stok_bahan >= 1 && $bahan->stok_bahan <= 5)
                                                                <span class="badge badge-pill bg-warning" style="font-size: 15px;">
                                                                    {{ $bahan->stok_bahan }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-pill bg-success" style="font-size: 15px;">
                                                                    {{ $bahan->stok_bahan }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $bahan->exp_bahan }}</td>
                                                        <td>
                                                            <a href="{{ route('data-bahan.show', $bahan->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat Detail</a>
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