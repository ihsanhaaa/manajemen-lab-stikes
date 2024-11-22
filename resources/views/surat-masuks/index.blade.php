@extends('layouts.app')

@section('title')
    Data Surat Masuk
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

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah Data Surat masuk
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Surat masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('data-surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nama_berkas" class="form-label">Perihal/Keterangan <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('nama_berkas') is-invalid @enderror" id="nama_berkas"
                                                    name="nama_berkas" value="{{ old('nama_berkas') }}" required>

                                                @error('nama_berkas')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <label for="nomor_berkas" class="form-label">Nomor Surat <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('nomor_berkas') is-invalid @enderror" id="nomor_berkas"
                                                    name="nomor_berkas" value="{{ old('nomor_berkas') }}" required>

                                                @error('nomor_berkas')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="kategori_berkas" class="form-label">Kategori <span style="color: red">*</span> </label>
                                                <select class="form-control @error('kategori_berkas') is-invalid @enderror" id="kategori_berkas" name="kategori_berkas">
                                                    <option value="">-- Pilih Kategori Surat --</option>
                                                    <option value="Surat Masuk">Surat Masuk</option>
                                                    <option value="Surat Keluar">Surat Keluar</option>
                                                    <option value="Surat SK">Surat SK</option>
                                                    <option value="Surat Penting">Surat Penting</option>
                                                    <option value="Surat Arsip">Surat Arsip</option>
                                                    <option value="Surat MOU">Surat MOU</option>
                                                </select>
                                            
                                                @error('kategori_berkas')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div id="tanggal-range" style="display: none;">
                                                <div class="mb-3">
                                                    <label for="stakeholder" class="form-label">Nama Stakeholder</label>
                                                    <input type="string" class="form-control @error('stakeholder') is-invalid @enderror" id="stakeholder" name="stakeholder" value="{{ old('stakeholder') }}">
                                                    @error('stakeholder')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                                                    @error('tanggal_mulai')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tanggal_berakhir" class="form-label mt-3">Tanggal Berakhir</label>
                                                    <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}">
                                                    @error('tanggal_berakhir')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                {{-- hanya satu foto --}}
                                                <label for="file_berkas" class="form-label">Berkas</label>
                                                <input type="file"
                                                    class="form-control @error('file_berkas') is-invalid @enderror" id="file_berkas"
                                                    name="file_berkas">

                                                @error('file_berkas')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="tanggal_berkas" class="form-label">Tanggal Surat <span style="color: red">*</span> </label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_berkas') is-invalid @enderror" id="tanggal_berkas"
                                                    name="tanggal_berkas" value="{{ old('tanggal_berkas') }}" required>

                                                @error('tanggal_berkas')
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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Data Surat masuk ({{ $surat_masuks->count() }})</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item active">Data Surat masuk</li>
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
                                                    <th>Perihal</th>
                                                    <th>Nomor Surat</th>
                                                    <th>Kategori</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                @foreach($surat_masuks as $key => $surat_masuk)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>{{ $surat_masuk->nama_berkas }}</td>
                                                        <td>{{ $surat_masuk->nomor_berkas }}</td>
                                                        <td>{{ $surat_masuk->kategori_berkas }}</td>
                                                        <td>
                                                            <a href="{{ asset('Berkas/'. $surat_masuk->file_berkas) }}" target="_blank" class="btn btn-success btn-sm mx-1"><i class="fas fa-eye"></i> Lihat Surat</a>
                                                            {{-- <a href="{{ route('data-surat-masuk.show', $surat_masuk->id) }}" class="btn btn-info btn-sm mx-1"><i class="fas fa-eye"></i> Lihat Detail</a> --}}
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

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const kategoriBerkas = document.getElementById('kategori_berkas');
                const tanggalRange = document.getElementById('tanggal-range');
        
                // Event listener untuk dropdown
                kategoriBerkas.addEventListener('change', function () {
                    if (kategoriBerkas.value === 'Surat MOU') {
                        tanggalRange.style.display = 'block'; // Tampilkan form tanggal
                    } else {
                        tanggalRange.style.display = 'none'; // Sembunyikan form tanggal
                    }
                });
            });
        </script>
    @endpush
@endsection