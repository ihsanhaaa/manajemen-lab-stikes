@extends('layouts.app')

@section('title')
    Data Obat
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
                                <h4 class="mb-sm-0">Data Obat ({{ $obats->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Obat</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Obat</a></li>
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

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success btn-sm mb-3 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-plus"></i> Tambah Data Obat
                            </button>

                            <a href="{{ route('laporan.obat.exportPDF') }}" class="btn btn-info btn-sm mb-3 mx-1">
                                <i class="fas fa-download"></i> Download Laporan PDF
                            </a>

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
                                                    <label for="kode_obat" class="form-label">Kode Obat <span style="color: red">*</span> </label>
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
                                                    <label for="nama_obat" class="form-label">Nama Obat <span style="color: red">*</span> </label>
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
                                                    <label for="jenis_obat" class="form-label">Jenis Obat <span style="color: red">*</span> </label>
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
                                                    <label for="kemasan_obat" class="form-label">Kemasan Obat <span style="color: red">*</span> </label>
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
                                                    <label for="bentuk_sediaan" class="form-label">Bentuk Sediaan <span style="color: red">*</span> </label>
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
                                                    <label for="stok_awal" class="form-label">Stok Awal <span style="color: red">*</span> </label>
                                                    <input type="number"
                                                        class="form-control @error('stok_awal') is-invalid @enderror" id="stok_awal"
                                                        name="stok_awal" value="{{ old('stok_awal') }}" required>

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

                            <div class="card">
                                <div class="card-body">
        
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode Obat</th>
                                                <th>Nama obat</th>
                                                <th>Kekuatan Obat</th>
                                                <th>Barang Masuk</th>
                                                <th>Barang Keluar</th>
                                                <th>Stok Akhir</th>
                                                <th>Expired</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($obats as $key => $obat)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td> <a href="{{ route('data-obat.show', $obat->id) }}"><u>{{ $obat->kode_obat }}</u></a> </td>
                                                        <td>{{ $obat->nama_obat }}</td>
                                                        <td>{{ $obat->kekuatan_obat }}</td>
                                                        <td>{{ $obat->stokMasuks->sum('jumlah_masuk') }}</td>
                                                        <td>{{ $obat->stokKeluars->sum('jumlah_pemakaian') }}</td>
                                                        <td>
                                                            @if ($obat->stok_obat == 0)
                                                                <span class="badge badge-pill bg-danger" style="font-size: 15px;">
                                                                    {{ $obat->stok_obat }}
                                                                </span>
                                                            @elseif($obat->stok_obat >= 1 && $obat->stok_obat <= 5)
                                                                <span class="badge badge-pill bg-warning" style="font-size: 15px;">
                                                                    {{ $obat->stok_obat }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-pill bg-success" style="font-size: 15px;">
                                                                    {{ $obat->stok_obat }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($obat->exp_obat)
                                                                @php
                                                                    $expDate = \Carbon\Carbon::parse($obat->exp_obat);
                                                                    $currentDate = \Carbon\Carbon::now();
                                                                    $daysRemaining = $currentDate->diffInDays($expDate, false);
                                                                    $formattedExpDate = $expDate->format('d-m-Y'); // Format tanggal-bulan-tahun
                                                                @endphp
                                                                @if ($daysRemaining < 0)
                                                                    <a href="#" class="badge badge-pill bg-danger" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="{{ $formattedExpDate }}">
                                                                        <span class="badge badge-pill bg-danger" style="font-size: 12px;">
                                                                            Expired {{ abs($daysRemaining) }} hari yang lalu
                                                                        </span> 
                                                                    </a>
                                                                @else
                                                                    <a href="#" class="badge badge-pill bg-success" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="{{ $formattedExpDate }}">
                                                                        <span class="badge badge-pill bg-success" style="font-size: 12px;">
                                                                            Sisa {{ $daysRemaining }} hari
                                                                        </span>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <a href="#" class="badge badge-pill bg-secondary" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Tanggal tidak tersedia">
                                                                    <span class="badge badge-pill bg-secondary" style="font-size: 12px;">
                                                                        Tanggal tidak tersedia
                                                                    </span>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('data-obat.show', $obat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
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