@extends('layouts.app')

@section('title')
    Detail Bahan
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
                                    <h4 class="mb-sm-0">Detail Bahan</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item">Data Bahan</li>
                                            <li class="breadcrumb-item active">Detail Bahan</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="d-flex">
                            <button type="button" class="btn btn-info btn-sm mb-3 mx-1" onclick="window.location='{{ route('data-bahan.index') }}'">
                                <i class="fas fa-angle-left"></i> Kembali ke Daftar Bahan
                            </button>
    
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning btn-sm mb-3 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-edit"></i> Ubah Data Bahan
                            </button>
    
                            <form action="{{ route('data-bahan.destroy', $bahan->id) }}" method="POST"
                                onsubmit="return confirm('Apakah anda yakin ingin menghapus bahan ini?');">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" style="border: none;" class="btn btn-danger btn-sm mb-3 mx-1"><i class="fas fa-trash-alt"></i> Hapus Data</button>
                            </form>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Bahan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('data-bahan.update', $bahan->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="kode_bahan" class="form-label">Kode Bahan <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('kode_bahan') is-invalid @enderror" id="kode_bahan"
                                                    name="kode_bahan" value="{{ $bahan->kode_bahan }}" required>

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
                                                    name="nama_bahan" value="{{ $bahan->nama_bahan }}" required>

                                                @error('nama_bahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="formula" class="form-label">Formula <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('formula') is-invalid @enderror" id="formula"
                                                    name="formula" value="{{ $bahan->formula }}" required>

                                                @error('formula')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="jenis_bahan" class="form-label">Jenis Bahan <span style="color: red">*</span> </label>
                                                <select class="form-control @error('jenis_bahan') is-invalid @enderror" id="jenis_bahan" name="jenis_bahan">
                                                    <option value="Cairan" {{ $bahan->jenis_bahan == 'Cairan' ? 'selected' : '' }}>Cairan</option>
                                                    <option value="Padat" {{ $bahan->jenis_bahan == 'Padat' ? 'selected' : '' }}>Padat</option>
                                                </select>
                                            
                                                @error('jenis_bahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="satuan" class="form-label">Satuan <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('satuan') is-invalid @enderror" id="satuan"
                                                    name="satuan" value="{{ $bahan->satuan }}" required>
                                            
                                                @error('satuan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="exp_bahan" class="form-label">Expired Bahan</label>
                                                <input type="date"
                                                    class="form-control @error('exp_bahan') is-invalid @enderror" id="exp_bahan"
                                                    name="exp_bahan" value="{{ $bahan->exp_bahan }}">

                                                @error('exp_bahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="stok_bahan" class="form-label">Sisa Bahan</label>
                                                <input type="number"
                                                    class="form-control @error('stok_bahan') is-invalid @enderror" id="stok_bahan"
                                                    name="stok_bahan" value="{{ $bahan->stok_bahan }}">

                                                @error('stok_bahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="mb-3"><i class="fas fa-seedling"></i> {{ $bahan->kode_bahan }} ◦ {{ $bahan->nama_bahan }}</h2>
                                        <div class="row">
                                            <div class="col">
                                                <p><strong>Formula:</strong> {{ $bahan->formula }}</p>
                                                <p><strong>Expired:</strong> {{ $bahan->exp_bahan ?? 'N/A' }}</p>
                                                <p><strong>Jenis Bahan:</strong> {{ $bahan->jenis_bahan ?? 'N/A' }}</p>
                                                <p><strong>Satuan:</strong> {{ $bahan->satuan ?? 'N/A' }}</p>
                                                <p><strong>Stok Awal:</strong> {{ $bahan->stok_awal ?? 'N/A' }}</p>
                                                <p><strong>Sisa Bahan:</strong> {{ $bahan->stok_bahan ?? 'N/A' }}</p>
                                            </div>
    
                                            <div class="col">
                                                <form action="{{ route('data-bahan.uploadFoto', $bahan->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="photo" class="form-label">Update Foto</label>
                                                        <input class="form-control" type="file" name="photo" id="photo" accept="image/*" multiple required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mb-3 btn-sm">Update Foto</button>
                                                </form>
                                                
                                                <div class="zoom-gallery">
            
                                                    @if ($bahan->foto_path)
                                                        <img src="{{ asset($bahan->foto_path) }}" class="img-fluid" alt="">
        
                                                        <form action="" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm my-3"><i class="fas fa-trash-alt"></i>  Hapus Foto</button>
                                                        </form>                                                
                                                    @else
                                                        <div class="alert alert-warning" role="alert">
                                                            Belum ada foto
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <h3>Stok Masuk</h3>
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Masuk</th>
                                                    <th>Jumlah Masuk</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Total Harga</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bahan->bahanMasuks as $bahanMasuk)
                                                    <tr>
                                                        <td>{{ $bahanMasuk->tanggal_masuk }}</td>
                                                        <td>{{ $bahanMasuk->jumlah_masuk }}</td>
                                                        <td>Rp. {{ number_format((float) $bahanMasuk->harga_satuan) }}</td>
                                                        <td>Rp. {{ number_format((float) $bahanMasuk->total_harga) }}</td>
                                                        <td>{{ $bahanMasuk->keterangan }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                
                                        <!-- Stok Keluar -->
                                        <h3 class="mt-3">Stok Keluar</h3>
                                        <table id="datatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Keluar</th>
                                                    <th>Jumlah Pemakaian</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bahan->bahanKeluars as $bahanKeluar)
                                                    <tr>
                                                        <td>{{ $bahanKeluar->tanggal_keluar }}</td>
                                                        <td>{{ $bahanKeluar->jumlah_pemakaian }}</td>
                                                        <td>
                                                            <!-- Keterangan atau Form Edit -->
                                                            <span class="keterangan-text">{{ $bahanKeluar->keterangan }}</span>
                                                            <form action="{{ route('bahan_keluar.update', $bahanKeluar->id) }}" method="POST" class="d-none form-edit-keterangan">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="text" name="keterangan" class="form-control" value="{{ $bahanKeluar->keterangan }}" required>
                                                                <div class="mt-2">
                                                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                                                    <button type="button" class="btn btn-sm btn-secondary btn-batal">Batal</button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <!-- Tombol Edit -->
                                                            <button class="btn btn-sm btn-primary btn-edit">Edit</button>
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
                const editButtons = document.querySelectorAll('.btn-edit');
                const cancelButtons = document.querySelectorAll('.btn-batal');

                editButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const row = this.closest('tr');
                        const keteranganText = row.querySelector('.keterangan-text');
                        const formEdit = row.querySelector('.form-edit-keterangan');

                        // Tampilkan form dan sembunyikan teks
                        keteranganText.classList.add('d-none');
                        formEdit.classList.remove('d-none');
                    });
                });

                cancelButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const row = this.closest('tr');
                        const keteranganText = row.querySelector('.keterangan-text');
                        const formEdit = row.querySelector('.form-edit-keterangan');

                        // Sembunyikan form dan tampilkan teks
                        formEdit.classList.add('d-none');
                        keteranganText.classList.remove('d-none');
                    });
                });
            });

        </script>
    @endpush
@endsection