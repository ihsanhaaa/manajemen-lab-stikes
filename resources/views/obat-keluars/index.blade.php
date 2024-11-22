@extends('layouts.app')

@section('title')
    Bahan Keluar
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

                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Error!</strong> {{ $message }}.
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
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah Data Bahan Keluar
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Bahan Keluar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('data-bahan-keluar.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="bahan_id" class="form-label">Nama Bahan <span style="color: red">*</span> </label>
                                                <select class="form-control @error('bahan_id') is-invalid @enderror" id="bahan_id" name="bahan_id" required>
                                                    <option value="">-- Pilih Bahan --</option>
                                                    @foreach($bahans as $bahan)
                                                        <option value="{{ $bahan->id }}">{{ $bahan->kode_bahan }} - {{ $bahan->nama_bahan }}</option>
                                                    @endforeach
                                                </select>
                                        
                                                @error('bahan_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="stok_bahan" class="form-label">Stok <span style="color: red">*</span> </label>
                                                <input type="text" class="form-control @error('stok_bahan') is-invalid @enderror" id="stok_bahan" name="stok_bahan" readonly required>
                                        
                                                @error('stok_bahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="jumlah_pemakaian" class="form-label">Jumlah Pemakaian <span style="color: red">*</span> </label>
                                                <input type="number" class="form-control @error('jumlah_pemakaian') is-invalid @enderror" id="jumlah_pemakaian" name="jumlah_pemakaian" required>
                                        
                                                @error('jumlah_pemakaian')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        
                                            <!-- Warning message for exceeding stock -->
                                            <div id="warning-message" style="display:none; color: red; font-weight: bold;">
                                                Jumlah pemakaian melebihi stok yang tersedia!
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="tanggal_keluar" class="form-label">Tanggal <span style="color: red">*</span> </label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_keluar') is-invalid @enderror" id="tanggal_keluar"
                                                    name="tanggal_keluar" required>
                                        
                                                @error('tanggal_keluar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                                    name="keterangan" required>
                                        
                                                @error('keterangan')
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
                                    <h4 class="mb-sm-0">Data Bahan Keluar ({{ $bahan_keluars->count() }})</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item active">Data Bahan Keluar</li>
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
                                                    <th>Kode Bahan</th>
                                                    <th>Nama Bahan</th>
                                                    <th>Stok Awal</th>
                                                    <th>Jumlah Pemakaian</th>
                                                    <th>Sisa Stok</th>
                                                    <th>Expired</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                @foreach($bahan_keluars as $key => $bahan_keluar)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>{{ $bahan_keluar->bahan->kode_bahan }}</td>
                                                        <td>{{ $bahan_keluar->bahan->nama_bahan }}</td>
                                                        <td>{{ $bahan_keluar->bahan->stok_bahan }}</td>
                                                        <td>{{ $bahan_keluar->jumlah_pemakaian }}</td>
                                                        <td>{{ $bahan_keluar->bahan->stok_bahan }}</td>
                                                        <td>{{ $bahan_keluar->bahan->exp_obat }}</td>
                                                        <td>
                                                            <a href="{{ route('data-bahan.show', $bahan->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat Detail</a>
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
        <script>
            // Mengambil stok bahan saat memilih bahan
            document.getElementById('bahan_id').addEventListener('change', function() {
                var bahanId = this.value;
        
                if (bahanId) {
                    fetch(`/get-stok-bahan/${bahanId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.stok_bahan !== undefined) {
                                document.getElementById('stok_bahan').value = data.stok_bahan;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        
            // Menampilkan pesan jika jumlah pemakaian melebihi stok
            document.getElementById('jumlah_pemakaian').addEventListener('input', function() {
                var jumlahPemakaian = parseInt(this.value, 10);
                var stokObat = parseInt(document.getElementById('stok_bahan').value, 10);
        
                var warningMessage = document.getElementById('warning-message');
        
                // Jika jumlah pemakaian lebih besar dari stok bahan
                if (jumlahPemakaian > stokObat) {
                    // Tampilkan pesan peringatan
                    warningMessage.style.display = 'block';
                } else {
                    // Sembunyikan pesan peringatan jika tidak lebih dari stok
                    warningMessage.style.display = 'none';
                }
            });
        </script>

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