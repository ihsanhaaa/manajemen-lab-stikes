@extends('layouts.app')

@section('title')
    Dashboard
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
                        
                        @role('Ketua STIKes')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-17 mb-2">Selamat Datang {{ Auth::user()->name }}</p>
                                                <p class="text-truncate font-size-14 mb-2">Email: {{ Auth::user()->email }}</p>
                                                <p class="text-truncate font-size-14 mb-2">Bergabung Pada: {{ Auth::user()->created_at }}</p>
                                                <p class="text-truncate font-size-14 mb-2">Anda masuk sebagai: {{ Auth::user()->getRoleNames()->first() }}</p>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-success btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#userModal">
                                                    <i class="fas fa-user"></i> Ubah Profil Saya
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="userModalLabel">Ubah Profil Saya</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="{{ route('update.profile') }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="name" class="form-label">Nama <span style="color: red">*</span></label>
                                                                        <input type="text"
                                                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                                                            name="name" value="{{ old('name', Auth::user()->name) }}" required>

                                                                        @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="email" class="form-label">Email <span style="color: red">*</span></label>
                                                                        <input type="email"
                                                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                                                            name="email" value="{{ old('email', Auth::user()->email) }}" required>

                                                                        @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>

                                                                    <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-info btn-sm mt-3 mx-1" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                                    <i class="fas fa-unlock-alt"></i> Ubah Password
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="passwordModalLabel">Ubah Password</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="{{ route('update.password') }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="password" class="form-label">Password Baru <span style="color: red">*</span></label>
                                                                        <input type="password"
                                                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                                                            name="password" required>

                                                                        @error('password')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span style="color: red">*</span></label>
                                                                        <input type="password"
                                                                            class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                                                            name="password_confirmation" required>

                                                                        @error('password_confirmation')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>

                                                                    <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
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
                                                    <h4 class="mb-2"> <a href="{{ route('pengajuan-bahan.index') }}">{{ $dataPengajuanBahan->count() }}</a> </h4>
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
                                                    <h4 class="mb-2"> <a href="{{ route('pengajuan-bahan.index') }}">{{ $dataPengajuanBahanbelumAcc->count() }}</a> </h4>
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
                                                    <h4 class="mb-2"> <a href="{{ route('data-obat.index') }}">{{ $obats->count() }}</a> </h4>
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
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('obats.filter', 'belum-expired') }}" class="badge bg-success">
                                                            {{ $belumExpiredCount }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Belum Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('obats.filter', 'mendekati-expired') }}" class="badge bg-warning">
                                                            {{ $mendekatiExpiredCount }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Mendekati Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('obats.filter', 'expired') }}" class="badge bg-danger">
                                                            {{ $expiredCount }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('data-obat-masuk.index') }}">
                                                            Rp. {{ number_format($obatMasuk) }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Total Obat Masuk - {{ $semesterAktif->semester ?? '-' }} {{ $semesterAktif->tahun_ajaran ?? '-' }}</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <a href="#" class="btn btn-light waves-effect" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Total Rp. {{ number_format($totalObatMasuk) }}">
                                                            <i class="ri-coins-line font-size-24"></i>  
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('obats.filter', 'mendekati-expired') }}">
                                                            Rp. {{ number_format($bahanMasuk) }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Total Bahan Masuk - {{ $semesterAktif->semester ?? '-' }} {{ $semesterAktif->tahun_ajaran ?? '-' }}</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <a href="#" class="btn btn-light waves-effect" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Total Rp. {{ number_format($totalBahanMasuk) }}">
                                                            <i class="ri-coins-line font-size-24"></i>  
                                                        </a> 
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('data-alat-masuk.index') }}">
                                                            Rp. {{ number_format($alatMasuk) }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Total Alat Masuk - {{ $semesterAktif->semester ?? '-' }} {{ $semesterAktif->tahun_ajaran ?? '-' }}</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <a href="#" class="btn btn-light waves-effect" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Total Rp. {{ number_format($totalAlatMasuk) }}">
                                                            <i class="ri-coins-line font-size-24"></i>  
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <div class="mb-3">
                                                        <h4 class="mb-sm-0 font-size-18">Grafik Stok Masuk dan Stok Keluar per Bulan Tahun {{ $tahunSekarang }}</h4>
                                                    </div>
                                                    <div style="width: 100%; height: 400px;">
                                                        <canvas id="stockChart" width="600" height="200"></canvas>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->


                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <div class="mb-3">
                                                        <h4 class="mb-sm-0 font-size-18">Rekap Surat Tahun {{ $tahunSekarang }}</h4>
                                                    </div>
                                                    <div style="width: 100%; height: 400px;">
                                                        <canvas id="suratChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->

                        @endrole

                        @role('Admin Lab')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-17 mb-2">Selamat Datang {{ Auth::user()->name }}</p>
                                                <p class="text-truncate font-size-14 mb-2">Email: {{ Auth::user()->email }}</p>
                                                <p class="text-truncate font-size-14 mb-2">Bergabung Pada: {{ Auth::user()->created_at }}</p>
                                                <p class="text-truncate font-size-14 mb-2">Anda masuk sebagai: {{ Auth::user()->getRoleNames()->first() }}</p>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-success btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#userModal">
                                                    <i class="fas fa-user"></i> Ubah Profil Saya
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="userModalLabel">Ubah Profil Saya</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="{{ route('update.profile') }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="name" class="form-label">Nama <span style="color: red">*</span></label>
                                                                        <input type="text"
                                                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                                                            name="name" value="{{ old('name', Auth::user()->name) }}" required>

                                                                        @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="email" class="form-label">Email <span style="color: red">*</span></label>
                                                                        <input type="email"
                                                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                                                            name="email" value="{{ old('email', Auth::user()->email) }}" required>

                                                                        @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>

                                                                    <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-info btn-sm mt-3 mx-1" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                                    <i class="fas fa-unlock-alt"></i> Ubah Password
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="passwordModalLabel">Ubah Password</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="{{ route('update.password') }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="password" class="form-label">Password Baru <span style="color: red">*</span></label>
                                                                        <input type="password"
                                                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                                                            name="password" required>

                                                                        @error('password')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span style="color: red">*</span></label>
                                                                        <input type="password"
                                                                            class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                                                            name="password_confirmation" required>

                                                                        @error('password_confirmation')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>

                                                                    <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
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
                                                    <h4 class="mb-2"> <a href="{{ route('pengajuan-bahan.index') }}">{{ $dataPengajuanBahan->count() }}</a> </h4>
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
                                                    <h4 class="mb-2"> <a href="{{ route('pengajuan-bahan.index') }}">{{ $dataPengajuanBahanbelumAcc->count() }}</a> </h4>
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
                                                    <h4 class="mb-2"> <a href="{{ route('data-obat.index') }}">{{ $obats->count() }}</a> </h4>
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
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('obats.filter', 'belum-expired') }}" class="badge bg-success">
                                                            {{ $belumExpiredCount }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Belum Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('obats.filter', 'mendekati-expired') }}" class="badge bg-warning">
                                                            {{ $mendekatiExpiredCount }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Mendekati Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2">
                                                        <a href="{{ route('obats.filter', 'expired') }}" class="badge bg-danger">
                                                            {{ $expiredCount }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-muted mb-0">Expired</p>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-calendar-check-fill font-size-24"></i>  
                                                    </span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <div class="mb-3">
                                                        <h4 class="mb-sm-0 font-size-18">Grafik Stok Masuk dan Stok Keluar per Bulan Tahun {{ $tahunSekarang }}</h4>
                                                    </div>
                                                    <div style="width: 100%; height: 400px;">
                                                        <canvas id="stockChart" width="600" height="200"></canvas>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->

                        @endrole

                        @role('Administrasi')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-17 mb-2">Selamat Datang {{ Auth::user()->name }}</p>
                                                    <p class="text-truncate font-size-14 mb-2">Email: {{ Auth::user()->email }}</p>
                                                    <p class="text-truncate font-size-14 mb-2">Bergabung Pada: {{ Auth::user()->created_at }}</p>
                                                    <p class="text-truncate font-size-14 mb-2">Anda masuk sebagai: {{ Auth::user()->getRoleNames()->first() }}</p>

                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#userModal">
                                                        <i class="fas fa-user"></i> Ubah Profil Saya
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="userModalLabel">Ubah Profil Saya</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <form action="{{ route('update.profile') }}" method="POST">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label for="name" class="form-label">Nama <span style="color: red">*</span></label>
                                                                            <input type="text"
                                                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                                                name="name" value="{{ old('name', Auth::user()->name) }}" required>

                                                                            @error('name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="email" class="form-label">Email <span style="color: red">*</span></label>
                                                                            <input type="email"
                                                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                                                name="email" value="{{ old('email', Auth::user()->email) }}" required>

                                                                            @error('email')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>

                                                                        <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-info btn-sm mt-3 mx-1" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                                        <i class="fas fa-unlock-alt"></i> Ubah Password
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="passwordModalLabel">Ubah Password</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <form action="{{ route('update.password') }}" method="POST">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label for="password" class="form-label">Password Baru <span style="color: red">*</span></label>
                                                                            <input type="password"
                                                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                                                name="password" required>

                                                                            @error('password')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span style="color: red">*</span></label>
                                                                            <input type="password"
                                                                                class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                                                                name="password_confirmation" required>

                                                                            @error('password_confirmation')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>

                                                                        <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            <button type="submit" class="btn btn-primary">Ubah Password</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <div class="mb-3">
                                                        <h4 class="mb-sm-0 font-size-18">Rekap Surat Tahun {{ $tahunSekarang }}</h4>
                                                    </div>
                                                    <div style="width: 100%; height: 400px;">
                                                        <canvas id="suratChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->
                        @endrole

                        @role('Mahasiswa')

                            @if (Auth::user()->mahasiswa_id)
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div class="flex-grow-1">
                                                        <p class="font-size-17 mb-2" style="word-break: break-word;">
                                                            <strong>Selamat Datang, {{ Auth::user()->mahasiswa->nama_mahasiswa }}</strong>
                                                        </p>
                                                        <p class="font-size-14 mb-2">Email: {{ Auth::user()->email }}</p>
                                                        <p class="font-size-14 mb-2">NIM: {{ Auth::user()->mahasiswa->nim }}</p>
                                                        <p class="font-size-14 mb-2">Semester: {{ Auth::user()->mahasiswa->semester }}</p>
                                                        <p class="font-size-14 mb-2">Tahun Masuk: {{ Auth::user()->mahasiswa->tahun_masuk }}</p>
                                                        <p class="text-truncate font-size-14 mb-2">Anda masuk sebagai: {{ Auth::user()->getRoleNames()->first() }}</p>

                                                        <a href="{{ route('pengajuan-bahan.index') }}"><h4 class="mb-2">{{ $dataPengajuanBahanUser->count() }}</h4></a>
                                                        <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"></span>Pengajuan Bahan Saya</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            @else
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>Info!</strong> Harap isikan NIM anda untuk melakukan verifikasi data mahasiswa.
                                </div>

                                <form action="{{ route('validate-nim') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Mahasiswa</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                                            disabled required>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nim" class="form-label">NIM <span
                                                style="color: red">*</span></label>
                                        <input type="number" class="form-control @error('nim') is-invalid @enderror"
                                            id="nim" name="nim" value="{{ old('nim') }}" required>

                                        @error('nim')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                    <button type="submit" class="btn btn-primary">Verifikasi Data</button>
                                </form>
                            @endif
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

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var ctx = document.getElementById('stockChart').getContext('2d');
                var stockChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($months),  // Label bulan
                        datasets: [
                            {
                                label: 'Stok Masuk',
                                data: @json($stokMasukData),  // Data stok masuk per bulan
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Stok Keluar',
                                data: @json($stokKeluarData),  // Data stok keluar per bulan
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Stok'
                                }
                            }
                        }
                    }
                });
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            const suratCharts = document.getElementById('suratChart').getContext('2d');
            const suratChart = new Chart(suratCharts, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_values($bulan)) !!}, // Nama bulan
                    datasets: [
                        {
                            label: 'Surat Masuk',
                            data: {!! json_encode(array_values($dataSurat['Surat Masuk'])) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna biru
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Surat Keluar',
                            data: {!! json_encode(array_values($dataSurat['Surat Keluar'])) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.5)', // Warna merah
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Surat SK',
                            data: {!! json_encode(array_values($dataSurat['Surat SK'])) !!},
                            backgroundColor: 'rgba(255, 206, 86, 0.5)', // Warna kuning
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Surat Penting',
                            data: {!! json_encode(array_values($dataSurat['Surat Penting'])) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.5)', // Warna hijau
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Surat MOU',
                            data: {!! json_encode(array_values($dataSurat['Surat MOU'])) !!},
                            backgroundColor: 'rgba(153, 102, 255, 0.5)', // Warna ungu
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Surat Arsip Yayasan PKPI',
                            data: {!! json_encode(array_values($dataSurat['Surat Arsip'])) !!},
                            backgroundColor: 'rgba(255, 159, 64, 0.5)', // Warna oranye
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    },
                    onClick: function(evt, elements) {
                        if (elements.length > 0) {
                            const chartElement = elements[0];
                            const monthLabel = this.data.labels[chartElement.index]; // Mendapatkan nama bulan
                            const redirectUrl = `/surat/${monthLabel}`; // URL redirect, sesuaikan dengan rute Anda
                            window.location.href = redirectUrl; // Redirect ke halaman
                        }
                    }
                }
            });
        </script>
        
    @endpush
@endsection