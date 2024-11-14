@extends('layouts.app')

@section('title')
    Detail Pengajuan Bahan
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
                                    <h4 class="mb-sm-0">Detail Pengajuan Bahan</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item">Pengajuan Bahan</li>
                                            <li class="breadcrumb-item active">Detail Pengajuan Bahan</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        @role('Admin Lab')
                            <form action="{{ route('pengajuan-bahan.destroy', $pengajuanBahan->id) }}"
                                method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data pengajuan bahan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mb-3"><i class="fas fa-trash-alt"></i> Hapus Data Pengajuan Bahan</button>
                            </form>
                        @endrole

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="mb-3"> <i class="fas fa-book"></i> {{ $pengajuanBahan->nama_praktikum }} ◦ <i class="fas fa-clock"></i> {{ $pengajuanBahan->tanggal_pelaksanaan }} </h2>
                                        <p><strong>Nama Kelompok:</strong> {{ $pengajuanBahan->nama_mahasiswa }}</p>
                                        <p><strong>NIM/Kelompok:</strong> {{ $pengajuanBahan->kelompok ?? 'N/A' }}</p>
                                        <p><strong>Kelas:</strong> {{ $pengajuanBahan->kelas ?? 'N/A' }}</p>

                                        <p><i class="fas fa-user"></i> {{ $pengajuanBahan->user->name }}</p>
                                        
                                        @if ($pengajuanBahan->status == 0)
                                            @role('Admin Lab')
                                                <form action="{{ route('pengajuan-bahan.konfirmasi.update', $pengajuanBahan->id) }}" method="post"
                                                    onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                </form>
                                            @endrole
                                        @else
                                            <button class="btn btn-success btn-sm" disabled><i class="fas fa-check-circle"></i> Sudah ACC</button>
                                        @endif

                                        <hr>

                                        <h3>Pemakaian Bahan</h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Kode Bahan/Obat</th>
                                                    <th>Nama Bahan/Obat</th>
                                                    <th>Jumlah Pemakaian</th>
                                                    <th>Satuan</th>
                                                    <th>Jenis Bahan/Obat</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pengajuanBahan->obatPengajuanBahans as $obatPengajuanBahan)
                                                    <tr>
                                                        <td>{{ $obatPengajuanBahan->obat->kode_obat ?? 'N/A' }}</td>
                                                        <td>{{ $obatPengajuanBahan->obat->nama_obat ?? 'N/A' }}</td>
                                                        <td>{{ $obatPengajuanBahan->jumlah_pemakaian }}</td> <!-- jumlah_pemakaian accessed directly from obatPengajuanBahan -->
                                                        <td>{{ $obatPengajuanBahan->obat->satuan->nama_satuan ?? 'N/A' }}</td> <!-- Accessing satuan if it is a related model -->
                                                        <td>{{ $obatPengajuanBahan->jenis_obat }}</td>
                                                        <td>{{ $obatPengajuanBahan->keterangan }}</td>
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