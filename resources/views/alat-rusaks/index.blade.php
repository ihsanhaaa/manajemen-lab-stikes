@extends('layouts.app')

@section('title')
    Data Alat Rusak
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
                                <h4 class="mb-sm-0">Data Alat Rusak ({{ $alat_rusaks->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Alat</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Alat Rusak</a></li>
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
                            <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-plus"></i> Tambah Data Alat Rusak
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Alat Rusak</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('data-alat-rusak.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="alat_id" class="form-label">Nama Alat/Barang <span style="color: red">*</span> </label>
                                                    <select class="form-control @error('alat_id') is-invalid @enderror" id="alat_id" name="alat_id" required>
                                                        <option value="">-- Pilih Alat --</option>
                                                        @foreach($alats as $alat)
                                                            <option value="{{ $alat->id }}" {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                                                                {{ $alat->nama_barang }} - Ukuran: {{ $alat->ukuran }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                            
                                                    @error('alat_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="stok" class="form-label">Stok <span style="color: red">*</span> </label>
                                                    <input type="text" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" readonly required
                                                           value="{{ old('stok') }}">
                                            
                                                    @error('stok')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="jumlah_rusak" class="form-label">Jumlah Rusak <span style="color: red">*</span> </label>
                                                    <input type="number" class="form-control @error('jumlah_rusak') is-invalid @enderror" id="jumlah_rusak"
                                                           name="jumlah_rusak" required value="{{ old('jumlah_rusak') }}">
                                            
                                                    @error('jumlah_rusak')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div id="warning-message" style="display:none; color: red; font-weight: bold;">
                                                    Jumlah pemakaian melebihi stok yang tersedia!
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="tanggal_rusak" class="form-label">Tanggal <span style="color: red">*</span> </label>
                                                    <input type="date" class="form-control @error('tanggal_rusak') is-invalid @enderror" id="tanggal_rusak"
                                                           name="tanggal_rusak" required value="{{ old('tanggal_rusak') }}">
                                            
                                                    @error('tanggal_rusak')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="nama_perusak" class="form-label">Nama Perusak <span style="color: red">*</span> </label>
                                                    <input type="text" class="form-control @error('nama_perusak') is-invalid @enderror" id="nama_perusak"
                                                           name="nama_perusak" required value="{{ old('nama_perusak') }}">
                                            
                                                    @error('nama_perusak')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                                           name="keterangan" value="{{ old('keterangan') }}">
                                            
                                                    @error('keterangan')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>
                                            
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
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
                                                <th>Tanggal Rusak</th>
                                                <th>Nama Alat/Barang</th>
                                                <th>Ukuran</th>
                                                <th>Jumlah Rusak</th>
                                                <th>Penyimpanan</th>
                                                <th>Letak Aset</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($alat_rusaks as $key => $alat_rusak)
                                                <tr>
                                                    <th scope="row">{{ $key + 1 }}</th>
                                                    <td>{{ $alat_rusak->tanggal_rusak }}</td>
                                                    <td>{{ $alat_rusak->alat->nama_barang ?? '-' }}</td>
                                                    <td>{{ $alat_rusak->alat->ukuran ?? '-' }}</td>
                                                    <td>{{ $alat_rusak->jumlah_rusak }}</td>
                                                    <td>{{ $alat_rusak->alat->penyimpanan ?? '-' }}</td>
                                                    <td>{{ $alat_rusak->alat->letak_aset ?? '-' }}</td>
                                                    <td>
                                                        <a href="{{ route('data-alat.show', $alat_rusak->alat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
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
        <script>
            // Mengambil stok alat saat memilih alat
            document.getElementById('alat_id').addEventListener('change', function() {
                var alatId = this.value;
        
                if (alatId) {
                    fetch(`/get-stok-alat/${alatId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.stok !== undefined) {
                                document.getElementById('stok').value = data.stok;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        
            // Menampilkan pesan jika jumlah pemakaian melebihi stok
            document.getElementById('jumlah_rusak').addEventListener('input', function() {
                var jumlahPemakaian = parseInt(this.value, 10);
                var stokObat = parseInt(document.getElementById('stok').value, 10);
        
                var warningMessage = document.getElementById('warning-message');
        
                // Jika jumlah pemakaian lebih besar dari stok alat
                if (jumlahPemakaian > stokObat) {
                    // Tampilkan pesan peringatan
                    warningMessage.style.display = 'block';
                } else {
                    // Sembunyikan pesan peringatan jika tidak lebih dari stok
                    warningMessage.style.display = 'none';
                }
            });
        </script>
    @endpush
@endsection