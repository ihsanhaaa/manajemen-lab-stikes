@extends('layouts.app')

@section('title')
    Status Obat
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
                                <h4 class="mb-sm-0">Obat {{ ucfirst(str_replace('-', ' ', $status)) }} ({{ $obats->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Status Obat</a></li>
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
                    
                    <div class="row">
                        <div class="col-lg-12">

                            <button type="button" class="btn btn-info btn-sm mb-3 mx-1" onclick="window.location='{{ route('home') }}'">
                                <i class="fas fa-angle-left"></i> Kembali ke Dashboard
                            </button>                            

                            <div class="card">
                                <div class="card-body">
        
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode Obat</th>
                                                <th>Nama obat</th>
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