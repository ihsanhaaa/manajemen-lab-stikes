@extends('layouts.app')

@section('title')
    Data Alat (Aset)
@endsection

@section('content')
    @push('css-plugins')
        
    @endpush

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- header -->
        @include('components.navbar')
        
        <!-- Start right Content here -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Data Alat/Aset ({{ $alats->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Alat</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Alat/Aset</a></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <strong>{{ $error }}</strong><br>
                            @endforeach
                        </div>
                    @endif

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
                    
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="d-flex">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="fas fa-plus"></i> Tambah Data Alat
                                </button>

                                {{-- <a href="{{ route('laporan.alat.exportPDF') }}" class="btn btn-info btn-sm mb-3 mx-1">
                                    <i class="fas fa-download"></i> Download Laporan PDF
                                </a> --}}

                                <div class="btn-group mb-3 mx-2">
                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cog"></i> Aksi <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('export.stok.alat') }}">Download Laporan Stok Alat</a>
                                    </div>
                                </div>
                            </div>

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
                                                    <label for="letak_aset" class="form-label">Letak Aset <span style="color: red">*</span></label>
                                                    <select class="form-control @error('letak_aset') is-invalid @enderror" 
                                                        id="letak_aset" 
                                                        name="letak_aset" 
                                                        required>
                                                        <option value="">-- Pilih Letak Aset --</option>
                                                        <option value="Lab Bawah" {{ old('letak_aset') == 'Lab Bawah' ? 'selected' : '' }}>Lab Bawah</option>
                                                        <option value="Lab Atas" {{ old('letak_aset') == 'Lab Atas' ? 'selected' : '' }}>Lab Atas</option>
                                                    </select>
                                            
                                                    @error('letak_aset')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
        
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Barang</th>
                                                <th>Ukuran</th>
                                                <th>Jumlah Alat Masuk</th>
                                                <th>Jumlah Alat Rusak</th>
                                                <th>Jumlah</th>
                                                <th>Penyimpanan</th>
                                                <th>Letak Aset</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
    

                                        <tbody>
                                            @foreach($alats as $key => $alat)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td> <a style="color: black" href="{{ route('data-alat.show', $alat->id) }}">{{ $alat->nama_barang }}</a> </td>
                                                        <td>{{ $alat->ukuran ?? '-' }}</td>
                                                        <td>{{ $alat->alatMasuks->sum('jumlah_masuk') }}</td>
                                                        <td>{{ $alat->alatRusaks->sum('jumlah_rusak') }}</td>
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
                                                        <td>{{ $alat->penyimpanan }}</td>
                                                        <td>{{ $alat->letak_aset }}</td>
                                                        <td>
                                                            <a href="{{ route('data-alat.show', $alat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <!-- end row -->

                </div>
                
            </div>
            <!-- End Page-content -->
           
            <!-- footer -->
            @include('components.footer')
            
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @push('javascript-plugins')
        
    @endpush
@endsection