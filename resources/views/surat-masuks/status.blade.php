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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Data Obat - {{ ucfirst(str_replace('-', ' ', $status)) }}</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item active">Data Obat {{ ucfirst(str_replace('-', ' ', $status)) }}</li>
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