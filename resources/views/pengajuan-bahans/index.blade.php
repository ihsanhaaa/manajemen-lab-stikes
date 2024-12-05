@extends('layouts.app')

@section('title')
    Data Pengajuan Obat dan Bahan
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
                                <h4 class="mb-sm-0">Data Pengajuan Obat dan Bahan ({{ $pengajuanbahans->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Obat</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Pengajuan Obat dan Bahan</a></li>
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
                            <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-plus"></i> Tambah Pengajuan Bahan
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importModalLabel">Form Pemakaian Bahan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('pengajuan-bahan.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <!-- Form data mahasiswa (nama, nim, kelas, dll) -->
                                                    <div class="mb-3">
                                                        <label for="anggota_kelompok" class="form-label">Nama Anggota Kelompok<span style="color: red;">*</span> </label>
                                                        <input type="text"
                                                            class="form-control @error('anggota_kelompok') is-invalid @enderror" id="anggota_kelompok"
                                                            name="anggota_kelompok" placeholder="Contoh: Budi, Adam, Widya" value="{{ old('anggota_kelompok') }}" required>
        
                                                        @error('kekuatan_obat')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="nim_kelompok" class="form-label">NIM/Kelompok<span style="color: red;">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('nim_kelompok') is-invalid @enderror" id="nim_kelompok"
                                                            name="nim_kelompok" value="{{ old('nim_kelompok') }}" required>
        
                                                        @error('nim_kelompok')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="kelas" class="form-label">Kelas<span style="color: red;">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('kelas') is-invalid @enderror" id="kelas"
                                                            name="kelas" value="{{ old('kelas') }}" required>
        
                                                        @error('kelas')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="tanggal_praktikum" class="form-label">Tanggal<span style="color: red;">*</span></label>
                                                        <input type="datetime-local"
                                                            class="form-control @error('tanggal_praktikum') is-invalid @enderror" id="tanggal_praktikum"
                                                            name="tanggal_praktikum" value="{{ old('tanggal_praktikum') }}" required>
        
                                                        @error('tanggal_praktikum')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="nama_praktikum" class="form-label">Nama Praktikum<span style="color: red;">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('nama_praktikum') is-invalid @enderror" id="nama_praktikum"
                                                            name="nama_praktikum" value="{{ old('nama_praktikum') }}" required>
        
                                                        @error('nama_praktikum')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <!-- Form for dynamic fields -->
                                                    <div id="dynamic-form-container">
                                                        <div class="row mb-3 dynamic-form">
                                                            <div class="col">
                                                                <label for="obat_id" class="form-label">Nama Bahan <span style="color: red">*</span> </label>
                                                                <select class="form-control" name="obat_id[]" required>
                                                                    <option value="">-- Pilih Obat --</option>
                                                                    <!-- Options obat akan diulang dari $obats -->
                                                                    @foreach($obats as $obat)
                                                                        <option value="{{ $obat->id }}">{{ $obat->kode_obat }} - {{ $obat->nama_obat }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col">
                                                                <label for="jumlah_pemakaian" class="form-label">Jumlah Pemakaian <span style="color: red">*</span> </label>
                                                                <input type="number" class="form-control" name="jumlah_pemakaian[]" required>
                                                            </div>

                                                            <div class="col">
                                                                <label for="satuan" class="form-label">Satuan <span style="color: red">*</span> </label>
                                                                <select class="form-control" name="satuan[]">
                                                                    <option value="">-- Pilih Satuan --</option>
                                                                    <!-- Options satuan akan diulang dari $satuans -->
                                                                    @foreach($satuans as $satuan)
                                                                        <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col">
                                                                <label for="jenis_obat" class="form-label">Jenis Obat <span style="color: red">*</span> </label>
                                                                <select class="form-control" name="jenis_obat[]">
                                                                    <option value="">-- Pilih Jenis Obat --</option>
                                                                    <option value="Cair">Cair</option>
                                                                    <option value="Padat">Padat</option>
                                                                </select>
                                                            </div>

                                                            <div class="col">
                                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                                <input type="text" class="form-control" name="keterangan[]">
                                                            </div>

                                                            <div class="col-auto d-flex align-items-end">
                                                                <button type="button" class="btn btn-danger btn-sm remove-form-btn">Hapus</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Button untuk menambah form -->
                                                    <button type="button" class="btn btn-success btn-sm mt-3" id="add-form-btn">Tambah form</button>
                                                </div>

                                                <div class="alert alert-warning" role="alert">
                                                    Data pemakaian bahan akan ditinjau oleh laboran sebelum disimpan!
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
        
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Praktikum</th>
                                                <th>Nama Kelompok</th>
                                                <th>NIM Kelompok</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pelaksanaan</th>
                                                @role('Admin Lab')
                                                    <th>Status</th>
                                                @endrole
                                                <th>Aksi</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($pengajuanbahans as $key => $obat)

                                                            <tr>
                                                                <th scope="row">{{ ++$key }}</th>
                                                                <td>{{ $obat->nama_praktikum }}</td>
                                                                <td>{{ $obat->nama_mahasiswa }}</td>
                                                                <td>{{ $obat->kelompok }}</td>
                                                                <td>{{ $obat->kelas }}</td>
                                                                <td>{{ $obat->tanggal_pelaksanaan }}</td>
                                                                <td>
                                                                    @if ($obat->status == 0)
                                                                        <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                                    @else
                                                                        <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @role('Admin Lab')
                                                                        @if ($obat->status == 0)
                                                                            <form action="{{ route('pengajuan-bahan.konfirmasi.update', $obat->id) }}" method="post"
                                                                                onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                                                @csrf
                                                                                <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                                            </form>
                                                                        @endif
                                                                    @endrole
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('pengajuan-bahan.show', $obat->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat Detail</a>
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
            // JavaScript untuk menangani penambahan dan penghapusan form
            document.getElementById('add-form-btn').addEventListener('click', function() {
                // Clone the existing form group
                const container = document.getElementById('dynamic-form-container');
                const newForm = container.firstElementChild.cloneNode(true);
        
                // Reset values in the cloned form
                newForm.querySelectorAll('input, select').forEach(input => input.value = '');
        
                // Append the new form to the container
                container.appendChild(newForm);
            });
        
            // Event listener untuk hapus form
            document.getElementById('dynamic-form-container').addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-form-btn')) {
                    const formGroup = event.target.closest('.dynamic-form');
                    if (formGroup && document.querySelectorAll('.dynamic-form').length > 1) {
                        formGroup.remove();
                    } else {
                        alert("Minimal satu form harus ada.");
                    }
                }
            });
        </script>
    @endpush
@endsection