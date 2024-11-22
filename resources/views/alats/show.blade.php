@extends('layouts.app')

@section('title')
    Detail Alat
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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Detail Alat</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item">Data Alat</li>
                                            <li class="breadcrumb-item active">Detail Alat</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning btn-sm mb-3 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-edit"></i> Ubah Data Alat
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('data-alat.update', $alat->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="nama_barang" class="form-label">Kode Alat <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang"
                                                    name="nama_barang" value="{{ $alat->nama_barang }}" required>

                                                @error('nama_barang')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <label for="ukuran" class="form-label">Nama Alat <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('ukuran') is-invalid @enderror" id="ukuran"
                                                    name="ukuran" value="{{ $alat->ukuran }}" required>

                                                @error('ukuran')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="jenis_obat" class="form-label">Jenis Alat <span style="color: red">*</span> </label>
                                                <select class="form-control @error('jenis_obat') is-invalid @enderror" id="jenis_obat" name="jenis_obat">
                                                    <option value="Cair" {{ $alat->jenis_obat == 'Cair' ? 'selected' : '' }}>Cair</option>
                                                    <option value="Padat" {{ $alat->jenis_obat == 'Padat' ? 'selected' : '' }}>Padat</option>
                                                </select>
                                            
                                                @error('jenis_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="kekuatan_obat" class="form-label">Kekuatan Alat</label>
                                                <input type="text"
                                                    class="form-control @error('kekuatan_obat') is-invalid @enderror" id="kekuatan_obat"
                                                    name="kekuatan_obat" value="{{ $alat->kekuatan_obat }}">

                                                @error('kekuatan_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update Data</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('data-alat.destroy', $alat->id) }}" class="btn btn-danger btn-sm mb-3 mx-1"><i class="fas fa-trash-alt"></i> Hapus Data</a>

                        <div class="row">

                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">
    
                                        <form action="{{ route('data-alat.uploadFoto', $alat->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Update Foto</label>
                                                <input class="form-control" type="file" name="photo" id="photo" accept="image/*" multiple required>
                                            </div>
                                            <button type="submit" class="btn btn-primary mb-3 btn-sm">Update Foto</button>
                                        </form>
                                        
                                        <div class="zoom-gallery">
    
                                            @if ($alat->foto_path)
                                                <img src="{{ asset($alat->foto_path) }}" class="img-fluid" alt="">

                                                <form action="{{ route('data-alat.deleteFoto', $alat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm my-3"><i class="fas fa-trash-alt"></i>  Hapus Foto</button>
                                                </form>                                                
                                            @else
                                                <div class="alert alert-warning" role="alert">
                                                    Belum ada foto
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="mb-3"><i class="fas fa-vials"></i> {{ $alat->nama_barang }}</h2>
                                        <p><strong>Ukuran:</strong> {{ $alat->ukuran }}</p>
                                        <p><strong>Letak Aset:</strong> {{ $alat->letak_aset }}</p>
                                        <p><strong>Penyimpanan:</strong> {{ $alat->penyimpanan ?? 'N/A' }}</p>
                                        
                                        <p><strong>Stok Alat:</strong> {{ $alat->stok ?? 'N/A' }}</p>

                                        <hr>

                                        <h3>Alat Masuk</h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Masuk</th>
                                                    <th>Jumlah Masuk</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($alat->alatMasuks as $alatMasuk)
                                                    <tr>
                                                        <td>{{ $alatMasuk->tanggal_masuk }}</td>
                                                        <td>{{ $alatMasuk->jumlah_masuk }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                
                                        <!-- Stok Keluar -->
                                        <h3>Alat Rusak</h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Rusak</th>
                                                    <th>Jumlah Rusak</th>
                                                    <th>Nama Rusak</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($alat->alatRusaks as $alatKeluar)
                                                    <tr>
                                                        <td>{{ $alatKeluar->tanggal_rusak }}</td>
                                                        <td>{{ $alatKeluar->jumlah_rusak }}</td>
                                                        <td>{{ $alatKeluar->nama_perusak }}</td>
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