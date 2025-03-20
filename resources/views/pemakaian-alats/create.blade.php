@extends('layouts.app')

@section('title')
    Tambah Pemakaian Alat
@endsection

@section('content')
    @push('css-plugins')
        <style>
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        </style>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
        <!-- jQuery (Select2 membutuhkan jQuery) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

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

                                <h4 class="mb-sm-0">Tambah Pemakaian Alat</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Tambah Pemakaian Alat</a></li>
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

                            @role('Admin Lab')
                                <div class="card">
                                    <div class="card-body">

                                        <form action="{{ route('pemakaian-alat.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                
                                                <div class="mb-3">
                                                    <label for="anggota_kelompok" class="form-label" style="font-size: 13px;">Nama Anggota Kelompok<span style="color: red;">*</span> </label>
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
                                                    <label for="nim_kelompok" class="form-label" style="font-size: 13px;">NIM Ketua Kelompok<span style="color: red;">*</span></label>
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
                                                    <label for="kelas" class="form-label" style="font-size: 13px;">Semester<span style="color: red;">*</span></label>
                                                    <select class="form-control @error('kelas') is-invalid @enderror" name="kelas" required>
                                                        <option value="">- Pilih -</option>
                                                        <option value="Semester 3" {{ old('kelas') == 'Semester 3' ? 'selected' : '' }}>Semester 3</option>
                                                        <option value="Semester 4" {{ old('kelas') == 'Semester 4' ? 'selected' : '' }}>Semester 4</option>
                                                        <option value="Semester 5" {{ old('kelas') == 'Semester 5' ? 'selected' : '' }}>Semester 5</option>
                                                        <option value="Semester 6" {{ old('kelas') == 'Semester 6' ? 'selected' : '' }}>Semester 6</option>
                                                    </select>
                                                    @error('kelas')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>                                                                                                                                           
                                        
                                                <div class="mb-3">
                                                    <label for="tanggal_praktikum" class="form-label" style="font-size: 13px;">
                                                        Tanggal Praktikum<span style="color: red;">*</span>
                                                    </label>
                                                    <input type="datetime-local" class="form-control" name="tanggal_praktikum" id="tanggal_praktikum" 
                                                        value="{{ old('tanggal_praktikum', now()->format('Y-m-d\TH:i')) }}" required>
                                                </div>                                                
                                        
                                                <div class="mb-4">
                                                    <label for="nama_praktikum" class="form-label" style="font-size: 13px;">Nama Praktikum<span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" name="nama_praktikum" placeholder="Nama Mata Kuliah - Pertemuan Ke-" required>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-size: 13px;">Nama Alat<span style="color: red;">*</span></th>
                                                                <th style="font-size: 13px;">Jumlah Pinjam<span style="color: red;">*</span></th>
                                                                <th style="font-size: 13px;">Kondisi Kembali<span style="color: red;">*</span></th>
                                                                <th style="font-size: 13px;">Jumlah Rusak<span style="color: red;">*</span></th>
                                                                <th style="font-size: 13px;">Keterangan</th>
                                                                <th style="font-size: 13px;">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamic-form-container">
                                                            <tr class="dynamic-form">
                                                                <td>
                                                                    <select class="form-control select2" name="alat[]" required>
                                                                        <option value="">- Pilih Alat -</option>
                                                                        @foreach($alats as $alat)
                                                                            <option value="{{ $alat->id }}">{{ $alat->nama_barang }} {{ $alat->ukuran }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>                                                                

                                                                <td>
                                                                    <input type="number" class="form-control" name="jumlah[]" required>
                                                                </td>

                                                                <td>
                                                                    <select class="form-control kondisi-kembali" name="kondisi_kembali[]" required>
                                                                        <option value="">- Pilih -</option>
                                                                        <option value="Baik">Baik</option>
                                                                        <option value="Pecah">Pecah</option>
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <input type="number" class="form-control jumlah-rusak" name="jumlah_rusak[]" required>
                                                                </td>

                                                                <td>
                                                                    <input type="text" class="form-control" name="keterangan[]">
                                                                </td>

                                                                <td>
                                                                    <button type="button" class="btn btn-danger remove-form-btn" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <button type="button" class="btn btn-success btn-sm mt-1" id="add-form-btn">Tambah Baris</button>

                                                <p class="mt-3">Keterangan: <span style="color: red">*</span>) wajib diisi</p>
                                            </div>
                                        
                                            <div class="modal-footer">
                                                <a href="{{ route('pengajuan-alat.index') }}" class="btn btn-secondary"
                                                    onclick="return confirm('Apakah Anda yakin? Data yang Anda isi akan hilang.')">
                                                    Batal
                                                </a>
                                                <button type="submit" class="btn btn-primary mx-2">Simpan</button>
                                            </div>
                                        </form>

                                    </div>
                                </div> 
                            @endrole

                            @role('Mahasiswa')
                                @if (Auth::user()->mahasiswa_id)
                                    <div class="card">
                                        <div class="card-body">

                                            <form action="{{ route('pemakaian-alat.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    
                                                    <div class="mb-3">
                                                        <label for="anggota_kelompok" class="form-label" style="font-size: 13px;">
                                                            Nama Anggota Kelompok<span style="color: red;">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="anggota_kelompok" 
                                                            value="{{ old('anggota_kelompok', Auth::user()->mahasiswa->nama_mahasiswa ? ucwords(strtolower(Auth::user()->mahasiswa->nama_mahasiswa)) : null) }}" 
                                                            placeholder="Contoh: Budi, Adam, Widya" required>
                                                    </div>                                                                                              
                                            
                                                    <div class="mb-3">
                                                        <label for="nim_kelompok" class="form-label" style="font-size: 13px;">
                                                            NIM Ketua Kelompok<span style="color: red;">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="nim_kelompok" id="nim_kelompok"
                                                            value="{{ old('nim_kelompok', Auth::user()->mahasiswa->nim ?? null) }}" required>
                                                    </div>                                                
                                                                                            
                                                    <div class="mb-3">
                                                        <label for="kelas" class="form-label" style="font-size: 13px;">
                                                            Semester<span style="color: red;">*</span>
                                                        </label>
                                                        <input type="text" class="form-control @error('kelas') is-invalid @enderror" 
                                                            name="kelas" id="kelas" 
                                                            value="{{ old('kelas', Auth::user()->mahasiswa->semester ?? null) }}" required readonly>
                                                    
                                                        @error('kelas')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>                                                                                                                                               
                                            
                                                    <div class="mb-3">
                                                        <label for="tanggal_praktikum" class="form-label" style="font-size: 13px;">
                                                            Tanggal Praktikum<span style="color: red;">*</span>
                                                        </label>
                                                        <input type="datetime-local" class="form-control" name="tanggal_praktikum" id="tanggal_praktikum" 
                                                            value="{{ old('tanggal_praktikum', now()->format('Y-m-d\TH:i')) }}" required>
                                                    </div>                                                
                                            
                                                    <div class="mb-4">
                                                        <label for="nama_praktikum" class="form-label" style="font-size: 13px;">Nama Praktikum<span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" name="nama_praktikum" placeholder="Nama Mata Kuliah - Pertemuan Ke-" required>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-size: 13px;">Nama Alat<span style="color: red;">*</span></th>
                                                                    <th style="font-size: 13px;">Jumlah Pinjam<span style="color: red;">*</span></th>
                                                                    <th style="font-size: 13px;">Kondisi Kembali<span style="color: red;">*</span></th>
                                                                    <th style="font-size: 13px;">Jumlah Rusak<span style="color: red;">*</span></th>
                                                                    <th style="font-size: 13px;">Keterangan</th>
                                                                    <th style="font-size: 13px;">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamic-form-container">
                                                                <tr class="dynamic-form">
                                                                    <td>
                                                                        <select class="form-control select2" name="alat[]" required>
                                                                            <option value="">- Pilih Alat -</option>
                                                                            @foreach($alats as $alat)
                                                                                <option value="{{ $alat->id }}">{{ $alat->nama_barang }} {{ $alat->ukuran }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>  

                                                                    <td>
                                                                        <input type="number" class="form-control" name="jumlah[]" required>
                                                                    </td>

                                                                    <td>
                                                                        <select class="form-control kondisi-kembali" name="kondisi_kembali[]" required>
                                                                            <option value="">- Pilih -</option>
                                                                            <option value="Baik">Baik</option>
                                                                            <option value="Pecah">Pecah</option>
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <input type="number" class="form-control jumlah-rusak" name="jumlah_rusak[]" required>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control" name="keterangan[]">
                                                                    </td>

                                                                    <td>
                                                                        <button type="button" class="btn btn-danger remove-form-btn" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <button type="button" class="btn btn-success btn-sm mt-1" id="add-form-btn">Tambah Baris</button>

                                                    <p class="mt-3">Keterangan: <span style="color: red">*</span>) wajib diisi</p>
                                                </div>
                                            
                                                <div class="modal-footer">
                                                    <a href="{{ route('pengajuan-alat.index') }}" class="btn btn-secondary"
                                                        onclick="return confirm('Apakah Anda yakin? Data yang Anda isi akan hilang.')">
                                                        Batal
                                                    </a>
                                                    <button type="submit" class="btn btn-primary mx-2">Simpan</button>
                                                </div>
                                            </form>

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
        $(document).ready(function () {
            // Inisialisasi Select2 pada elemen yang sudah ada
            $('.select2').select2({
                placeholder: "- Pilih Alat -",
                allowClear: true
            });
    
            // Tambahkan Baris Baru
            $('#add-form-btn').on('click', function () {
                const newForm = $('.dynamic-form:first').clone();
    
                // Reset nilai input dalam baris yang baru
                newForm.find('input, select').val('');
                newForm.find('.select2-container').remove(); // Hapus Select2 lama sebelum menambah yang baru
                newForm.find('select').removeClass('select2-hidden-accessible'); // Reset class select2 sebelumnya
                newForm.find('.select2').select2({ // Re-inisialisasi Select2
                    placeholder: "- Pilih Alat -",
                    allowClear: true
                });
    
                $('#dynamic-form-container').append(newForm);
            });
    
            // Hapus Baris
            $('#dynamic-form-container').on('click', '.remove-form-btn', function () {
                if ($('.dynamic-form').length > 1) {
                    $(this).closest('.dynamic-form').remove();
                } else {
                    alert('Minimal satu baris harus ada.');
                }
            });
    
            // Event Listener untuk Kondisi Kembali
            $(document).on('change', '.kondisi-kembali', function () {
                const kondisi = $(this).val();
                const jumlahRusakInput = $(this).closest('tr').find('.jumlah-rusak');
    
                if (kondisi === 'Baik') {
                    jumlahRusakInput.val(0).prop('readonly', true);
                } else {
                    jumlahRusakInput.val('').prop('readonly', false);
                }
            });
        });
    </script>
    
    
    
    @endpush
@endsection