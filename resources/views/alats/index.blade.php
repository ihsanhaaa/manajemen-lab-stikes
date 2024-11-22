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
                        <button type="button" class="btn btn-primary mb-3 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah Data Alat
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Alat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('data-alat.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nama_barang" class="form-label">Nama Barang <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang"
                                                    name="nama_barang" value="{{ old('nama_barang') }}" placeholder="contoh: Spuit 1 cc" required>

                                                @error('nama_barang')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <label for="stok" class="form-label">Stok <span style="color: red">*</span> </label>
                                                <input type="number"
                                                    class="form-control @error('stok') is-invalid @enderror" id="stok"
                                                    name="stok" value="{{ old('stok') }}" required>

                                                @error('stok')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                {{-- hanya satu foto --}}
                                                <label for="foto_path" class="form-label">Foto (opsional)</label>
                                                <input type="file"
                                                    class="form-control @error('foto_path') is-invalid @enderror" id="foto_path"
                                                    name="foto_path">

                                                @error('foto_path')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="ukuran" class="form-label">Ukuran (opsional) </label>
                                                <input type="text"
                                                    class="form-control @error('ukuran') is-invalid @enderror" id="ukuran"
                                                    name="ukuran" value="{{ old('ukuran') }}" placeholder="contoh: 1 cc/ml">

                                                @error('ukuran')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="jumlah" class="form-label">Jumlah <span style="color: red">*</span> </label>
                                                <input type="number"
                                                    class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                                                    name="jumlah" value="{{ old('jumlah') }}" required>

                                                @error('jumlah')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="penyimpanan" class="form-label">Penyimpanan <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('penyimpanan') is-invalid @enderror" id="penyimpanan"
                                                    name="penyimpanan" value="{{ old('penyimpanan') }}" placeholder="contoh: Lab Depan/Lab Belakang/Lemari Belakang" required>
                                            
                                                @error('penyimpanan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="letak_aset" class="form-label">Letak Aset <span style="color: red">*</span> </label>
                                                <select class="form-control @error('letak_aset') is-invalid @enderror" id="letak_aset" name="letak_aset" required>
                                                    <option value="">-- Pilih Letak Aset --</option>
                                                    <option value="Lab Bawah">Lab Bawah</option>
                                                    <option value="Lab Atas">Lab Atas</option>
                                                </select>
                                            
                                                @error('letak_aset')
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
                                    <h4 class="mb-sm-0">Data Alat ({{ $alats->count() }})</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item active">Data Alat</li>
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
                                                    <th>Nama Barang</th>
                                                    <th>Stok</th>
                                                    <th>Ukuran</th>
                                                    <th>Jumlah Alat Masuk</th>
                                                    <th>Jumlah Alat Rusak</th>
                                                    <th>Penyimpanan</th>
                                                    <th>Letak Aset</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                @foreach($alats as $key => $alat)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>{{ $alat->nama_barang }}</td>
                                                        <td>
                                                            @if ($alat->stok == 0)
                                                                <span class="badge badge-pill bg-danger" style="font-size: 15px;">
                                                                    {{ $alat->stok }}
                                                                </span>
                                                            @elseif($alat->stok >= 1 && $alat->stok <= 5)
                                                                <span class="badge badge-pill bg-warning" style="font-size: 15px;">
                                                                    {{ $alat->stok }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-pill bg-success" style="font-size: 15px;">
                                                                    {{ $alat->stok }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $alat->ukuran }}</td>

                                                        {{-- <td>{{ $alat->stok_obat }}</td> --}}
                                                        <td>{{ $alat->alatMasuks->sum('jumlah_masuk') }}</td>
                                                        <td>{{ $alat->alatRusaks->sum('jumlah_rusak') }}</td>
                                                        <td>{{ $alat->penyimpanan }}</td>
                                                        <td>{{ $alat->letak_aset }}</td>
                                                        <td>
                                                            <a href="{{ route('data-alat.show', $alat->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat Detail</a>
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