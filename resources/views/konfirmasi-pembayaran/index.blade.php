@extends('layouts.app')

@section('title')
    Data Konfirmasi Pembayaran
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
                                <h4 class="mb-sm-0">Data Konfirmasi Pembayaran</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Konfirmasi Pembayaran</a></li>
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
                                <i class="fas fa-plus"></i> Tambah Data Konfirmasi Pembayaran
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Konfirmasi Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('konfirmasi-pembayaran.store') }}" method="POST" enctype="multipart/form-data">
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
                                                    <label for="tanggal" class="form-label">Tanggal Bayar<span style="color: red">*</span> </label>
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
                                                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran<span style="color: red">*</span> </label>
                                                    <select class="form-control @error('jenis_pembayaran') is-invalid @enderror" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Gedung">Gedung</option>
                                                        <option value="SPP">SPP</option>
                                                        <option value="Jas Lab">Jas Lab</option>
                                                        <option value="Skripsi">Skripsi</option>
                                                        <option value="PKL">PKL</option>
                                                        <option value="Wisuda">Wisuda</option>
                                                    </select>
                                                
                                                    @error('jenis_pembayaran')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="bukti_bayar" class="form-label">Bukti Bayar<span style="color: red">*</span> (Foto atau file PDF maks 2 MB) </label>
                                                    <input type="file"
                                                        class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar"
                                                        name="bukti_bayar[]" multiple required>
                                                
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
                                                <th>Tanggal Bayar</th>
                                                <th>Bukti Bayar</th>
                                                <th>Jenis Pembayaran</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($buktiPembayarans as $key => $buktiPembayaran)
                                                <tr>
                                                    <th scope="row">{{ ++$key }}</th>
                                                    <td>{{ $buktiPembayaran->user->name }} - {{ $buktiPembayaran->user->nim }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($buktiPembayaran->tanggal)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @if($buktiPembayaran->fotoBuktiBayars->isNotEmpty())
                                                            @foreach($buktiPembayaran->fotoBuktiBayars as $foto)
                                                                <a href="{{ asset($foto->foto_path) }}" target="_blank">
                                                                    <img src="{{ asset($foto->foto_path) }}" alt="Bukti Bayar" class="img-thumbnail" style="max-width: 30px;">
                                                                </a>
                                                            @endforeach
                                                        @else
                                                            <span>Tidak ada bukti bayar</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $buktiPembayaran->jenis_pembayaran }}</td>
                                                    <td>
                                                        @if($buktiPembayaran->status == 1)
                                                            <span class="badge bg-success">Sudah ACC</span>
                                                        @else
                                                            <span class="badge bg-danger">Belum ACC</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($buktiPembayaran->status == 0)
                                                            <form action="{{ route('updateStatusKonfirmasiBayar', $buktiPembayaran->id) }}" method="POST" 
                                                                onsubmit="return confirm('Apakah anda yakin ingin mengkonfirmasi data pembayaran ini?');">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary btn-sm mx-1" title="ACC">
                                                                    <i class="fas fa-check-circle"></i>
                                                                </button>
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