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
                                    <h4 class="mb-sm-0">Detail Obat</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Beranda</a></li>
                                            <li class="breadcrumb-item">Data Obat</li>
                                            <li class="breadcrumb-item active">Detail Obat</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="d-flex">
                            <button type="button" class="btn btn-info btn-sm mb-3 mx-1" onclick="window.location='{{ route('data-obat.index') }}'">
                                <i class="fas fa-angle-left"></i> Kembali ke Daftar Obat
                            </button>
    
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning btn-sm mb-3 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-edit"></i> Edit Data Obat
                            </button>
    
                            <form action="{{ route('data-obat.destroy', $obat->id) }}" method="POST"
                                onsubmit="return confirm('Apakah anda yakin ingin menghapus obat ini?');">
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
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Obat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('data-obat.update', $obat->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="kode_obat" class="form-label">Kode Obat <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('kode_obat') is-invalid @enderror" id="kode_obat"
                                                    name="kode_obat" value="{{ $obat->kode_obat }}" required>

                                                @error('kode_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_obat" class="form-label">Nama Obat <span style="color: red">*</span> </label>
                                                <input type="text"
                                                    class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat"
                                                    name="nama_obat" value="{{ $obat->nama_obat }}" required>

                                                @error('nama_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="jenis_obat" class="form-label">Jenis Obat <span style="color: red">*</span> </label>
                                                <select class="form-control @error('jenis_obat') is-invalid @enderror" id="jenis_obat" name="jenis_obat">
                                                    <option value="Cair" {{ $obat->jenis_obat == 'Cair' ? 'selected' : '' }}>Cair</option>
                                                    <option value="Padat" {{ $obat->jenis_obat == 'Padat' ? 'selected' : '' }}>Padat</option>
                                                </select>
                                            
                                                @error('jenis_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="kekuatan_obat" class="form-label">Kekuatan Obat</label>
                                                <input type="text"
                                                    class="form-control @error('kekuatan_obat') is-invalid @enderror" id="kekuatan_obat"
                                                    name="kekuatan_obat" value="{{ $obat->kekuatan_obat }}">

                                                @error('kekuatan_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="kemasan_id" class="form-label">Kemasan Obat</label>
                                                <select class="form-control @error('kemasan_id') is-invalid @enderror" id="kemasan_id" name="kemasan_id" required>
                                                    <option value="">-- Pilih Kemasan Obat --</option>
                                                    @foreach($kemasans as $kemasan)
                                                        <option value="{{ $kemasan->id }}" {{ old('kemasan_id', $obat->kemasan_id) == $kemasan->id ? 'selected' : '' }}>
                                                            {{ $kemasan->nama_kemasan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('kemasan_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>                                            

                                            <div class="mb-3">
                                                <label for="bentuk_sediaan_id" class="form-label">Bentuk Sediaan</label>
                                                <select class="form-control @error('bentuk_sediaan_id') is-invalid @enderror" id="bentuk_sediaan_id" name="bentuk_sediaan_id" required>
                                                    <option value="">-- Pilih Bentuk Sediaan --</option>
                                                    @foreach($bentukSediaans as $bentukSediaan)
                                                        <option value="{{ $bentukSediaan->id }}" {{ old('bentuk_sediaan_id', $obat->bentuk_sediaan_id) == $bentukSediaan->id ? 'selected' : '' }}>
                                                            {{ $bentukSediaan->nama_bentuk_sediaan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('bentuk_sediaan_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>                                            

                                            <div class="mb-3">
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <select class="form-control @error('satuan_id') is-invalid @enderror" id="satuan" name="satuan_id">
                                                    <option value="">-- Pilih Satuan --</option>
                                                    @foreach($satuans as $satuan)
                                                        <option value="{{ $satuan->id }}" {{ $obat->satuan_id == $satuan->id ? 'selected' : '' }}>
                                                            {{ $satuan->nama_satuan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            
                                                @error('satuan_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>                                            

                                            <div class="mb-3">
                                                <label for="exp_obat" class="form-label">Expired Obat</label>
                                                <input type="date"
                                                    class="form-control @error('exp_obat') is-invalid @enderror" id="exp_obat"
                                                    name="exp_obat" value="{{ $obat->exp_obat }}">

                                                @error('exp_obat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="stok_obat" class="form-label">Stok Obat</label>
                                                <input type="number"
                                                    class="form-control @error('stok_obat') is-invalid @enderror" id="stok_obat"
                                                    name="stok_obat" value="{{ $obat->stok_obat }}" required>

                                                @error('stok_obat')
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

                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">
    
                                        <form action="{{ route('data-obat.uploadFoto', $obat->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Update Foto</label>
                                                <input class="form-control" type="file" name="photo" id="photo" accept="image/*" multiple required>
                                            </div>
                                            <button type="submit" class="btn btn-primary mb-3 btn-sm">Update Foto</button>
                                        </form>
                                        
                                        <div class="zoom-gallery">
    
                                            @if ($obat->foto_path)
                                                <img src="{{ asset($obat->foto_path) }}" class="img-fluid" alt="">

                                                <form action="{{ route('data-obat.deleteFoto', $obat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
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
                            </div>

                            <div class="col-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="mb-2"><i class="fas fa-pills"></i> {{ $obat->kode_obat }} ◦ {{ $obat->nama_obat }}</h2>
                                        <p><strong>Kekuatan Obat:</strong> {{ $obat->kekuatan_obat }}</p>
                                        <p><strong>Kemasan Obat:</strong> {{ $obat->kemasan->nama_kemasan ?? 'N/A' }}</p>
                                        <p><strong>Bentuk Sediaan:</strong> {{ $obat->bentukSediaan->nama_bentuk_sediaan ?? 'N/A' }}</p>
                                        <p><strong>Satuan:</strong> {{ $obat->satuan->nama_satuan ?? 'N/A' }}</p>
                                        
                                        <p><strong>Stok Awal:</strong> {{ $obat->stok_awal ?? 'N/A' }}</p>
                                        <p><strong>Stok Akhir:</strong> {{ $obat->stok_obat ?? 'N/A' }}</p>
                                        

                                        <hr>

                                        <h3>Stok Masuk</h3>
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Masuk</th>
                                                    <th>Jumlah Masuk</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Total Harga</th>
                                                    <th>keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($obat->stokMasuks as $stokMasuk)
                                                    <tr>
                                                        <td>{{ $stokMasuk->tanggal_masuk }}</td>
                                                        <td>{{ $stokMasuk->jumlah_masuk }}</td>
                                                        <td>Rp. {{ number_format((float) $stokMasuk->harga_satuan) }}</td>
                                                        <td>Rp. {{ number_format((float) $stokMasuk->total_harga) }}</td>
                                                        <td>{{ $stokMasuk->keterangan }}</td>
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
                                                    <th>keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($obat->stokKeluars as $stokKeluar)
                                                    <tr>
                                                        <td>{{ $stokKeluar->tanggal_keluar }}</td>
                                                        <td>{{ $stokKeluar->jumlah_pemakaian }}</td>
                                                        <td>{{ $stokKeluar->keterangan }}</td>
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
                
                @include('components.footer')
                
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