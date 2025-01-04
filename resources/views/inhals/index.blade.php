@extends('layouts.app')

@section('title')
    Data Inhal
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
                                <h4 class="mb-sm-0">Data Inhal</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Inhal</a></li>
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
                                <i class="fas fa-plus"></i> Tambah Data Inhal
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Inhal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('data-inhal.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa<span style="color: red">*</span></label>
                                                    <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" id="nama_mahasiswa"
                                                        name="nama_mahasiswa" value="{{ Auth::user()->name }}" required>
                                                               
                                                    @error('nama_mahasiswa')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="nim" class="form-label">NIM<span style="color: red">*</span></label>
                                                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                                                        name="nim" value="{{ Auth::user()->nim }}" required>
                                                               
                                                    @error('nim')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="nama_praktikum" class="form-label">Nama Praktikum<span style="color: red">*</span> </label>
                                                            <input type="text"
                                                                class="form-control @error('nama_praktikum') is-invalid @enderror" id="nama_praktikum"
                                                                name="nama_praktikum" value="{{ old('nama_praktikum') }}" required>

                                                            @error('nama_praktikum')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="col">
                                                            <label for="percobaan" class="form-label">Percobaan<span style="color: red">*</span> </label>
                                                            <input type="text"
                                                                class="form-control @error('percobaan') is-invalid @enderror" id="percobaan"
                                                                name="percobaan" value="{{ old('percobaan') }}" placeholder="contoh: Percobaan ke-1" required>

                                                            @error('percobaan')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label">Tanggal<span style="color: red">*</span> </label>
                                                    <input type="date"
                                                        class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                                                        name="tanggal" value="{{ old('tanggal') }}" required>

                                                    @error('tanggal')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="bukti_bayar" class="form-label">Bukti Bayar<span style="color: red">*</span> </label>
                                                    <input type="file"
                                                        class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar"
                                                        name="bukti_bayar" value="{{ old('bukti_bayar') }}" required>

                                                    @error('bukti_bayar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                                                <th>Nama Mahasiswa - NIM</th>
                                                <th>Nama Praktikum - Percobaan ke</th>
                                                <th>Tanggal</th>
                                                <th>Bukti Pembayaran</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                                @foreach($inhals as $key => $inhal)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>{{ $inhal->user->name }} - {{ $inhal->user->nim }}</td>
                                                        <td>{{ $inhal->nama_praktikum }} - {{ $inhal->percobaan }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($inhal->tanggal)->format('d-m-Y') }}</td>
                                                        <td>
                                                            <a href="{{ asset($inhal->bukti_bayar) }}" target="_blank">
                                                                <i class="fas fa-file"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            @if($inhal->status == 1)
                                                                <span class="badge bg-success">Sudah ACC</span>
                                                            @else
                                                                <span class="badge bg-danger">Belum ACC</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($inhal->status == 0)
                                                                <form action="{{ route('updateStatus', $inhal->id) }}"
                                                                    method="POST" onsubmit="return confirm('Apakah anda yakin ingin mengkonfirmasi data inhal ini?');">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary btn-sm mx-1" title="ACC"><i class="fas fa-check-circle"></i></button>
                                                                </form>
                                                            @endif
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