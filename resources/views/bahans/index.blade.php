@extends('layouts.app')

@section('title')
    Data Bahan
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
                                <h4 class="mb-sm-0">Data Bahan ({{ $bahans->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bahan</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Bahan</a></li>
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
                            <div class="d-flex align-items-center mb-3">
                                <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="fas fa-plus"></i> Tambah Data Bahan
                                </button>
    
                                {{-- <a href="{{ route('laporan.bahan.exportPDF') }}" class="btn btn-info btn-sm mb-3 mx-1">
                                    <i class="fas fa-download"></i> Download Laporan PDF
                                </a> --}}
                            
                                <!-- Form Download Laporan -->
                                <form action="/download-laporan-bahan" method="GET" class="d-inline">
                                    <div class="input-group">
                                        <input type="month" name="bulan_tahun" class="form-control form-control-sm" required>
                                        <button type="submit" class="btn btn-info btn-sm">
                                            <i class="fas fa-download"></i> Download Laporan
                                        </button>
                                    </div>
                                </form>
                            </div>

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
                                                        <option value="Cairan">Cair</option>
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

                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#bahanPadat" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-tint"></i></span>
                                                <span class="d-none d-sm-block">Bahan Padat</span> 
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#bahanCair" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-window-maximize"></i></span>
                                                    <span class="d-none d-sm-block">Bahan Cair</span> 
                                            </a>
                                        </li>
                                    </ul>
    
                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="bahanPadat" role="tabpanel">

                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode - Nama Bahan</th>
                                                        <th>Jenis</th>
                                                        <th>Bahan Masuk</th>
                                                        <th>Bahan Keluar</th>
                                                        <th>Stok</th>
                                                        <th>Expired</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    @php $counter = 1; @endphp
                                                    @foreach($bahans as $bahan)
        
                                                         @if($bahan->jenis_bahan == 'Padat')
                                                            <tr>
                                                                <th scope="row">{{ $counter++ }}</th>
                                                                <td> <a style="color: black" href="{{ route('data-bahan.show', $bahan->id) }}">{{ $bahan->kode_bahan }} - {{ $bahan->nama_bahan }}</a> </td>
                                                                <td>{{ $bahan->jenis_bahan }}</td>
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
                                                                <td>
                                                                    @if ($bahan->exp_bahan)
                                                                        @php
                                                                            $expDate = \Carbon\Carbon::parse($bahan->exp_bahan);
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
                                                                        <span class="badge badge-pill bg-secondary" style="font-size: 12px;">
                                                                            Tanggal tidak tersedia
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('data-bahan.show', $bahan->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
                                                                </td>
                                                            </tr>
                                                         @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                        <div class="tab-pane" id="bahanCair" role="tabpanel">

                                            <table id="datatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode - Nama Bahan</th>
                                                        <th>Jenis</th>
                                                        <th>Bahan Masuk</th>
                                                        <th>Bahan Keluar</th>
                                                        <th>Stok</th>
                                                        <th>Expired</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    @php $counter2 = 1; @endphp
                                                    @foreach($bahans as $bahan)
        
                                                         @if($bahan->jenis_bahan != 'Padat')
                                                            <tr>
                                                                <th scope="row">{{ $counter2++ }}</th>
                                                                <td> <a style="color: black" href="{{ route('data-bahan.show', $bahan->id) }}">{{ $bahan->kode_bahan }} - {{ $bahan->nama_bahan }}</a> </td>
                                                                <td>{{ $bahan->jenis_bahan }}</td>
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
                                                                <td>
                                                                    @if ($bahan->exp_bahan)
                                                                        @php
                                                                            $expDate = \Carbon\Carbon::parse($bahan->exp_bahan);
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
                                                                        <span class="badge badge-pill bg-secondary" style="font-size: 12px;">
                                                                            Tanggal tidak tersedia
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('data-bahan.show', $bahan->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
                                                                </td>
                                                            </tr>
                                                         @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
        
                                    

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