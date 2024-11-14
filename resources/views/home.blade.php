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
                                    <h4 class="mb-sm-0">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active"><a href="javascript: void(0);">Dashboard</a></li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        @role('Admin Lab')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-17 mb-2">Selamat Datang {{ Auth::user()->name }}</p>
                                                    <p class="text-truncate font-size-14 mb-2">Anda masuk sebagai: {{ Auth::user()->getRoleNames()->first() }}</p>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->

                            <div class="row">
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">{{ $dataPengajuanBahan->count() }}</h4>
                                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"></span>Total Pengajuan Bahan</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-inbox-unarchive-line font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->

                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">{{ $dataPengajuanBahanbelumAcc->count() }}</h4>
                                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"></span>Pengajuan Bahan Belum ACC</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-inbox-archive-line font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->

                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">{{ $obats->count() }}</h4>
                                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"></span>Jumlah Obat</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-line-chart-line font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->

                            <div class="row">
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2"> <span class="badge bg-success">{{ $obats->count() }}</span> </h4>
                                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"></span>Belum Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->

                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2"> <span class="badge bg-warning">{{ $obats->count() }}</span> </h4>
                                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"></span>Mendekati Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->

                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2"> <span class="badge bg-danger">{{ $obats->count() }}</span> </h4>
                                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"></span>Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->


                        @endrole

                        @role('Mahasiswa')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-17 mb-2">Selamat Datang {{ Auth::user()->name }}</p>
                                                    <p class="text-truncate font-size-14 mb-2">Anda masuk sebagai: {{ Auth::user()->getRoleNames()->first() }}</p>

                                                    <h4 class="mb-2">{{ $dataPengajuanBahanUser->count() }}</h4>
                                                    <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"></span>Pengajuan Bahan Saya</p>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->
                        @endrole
                        
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