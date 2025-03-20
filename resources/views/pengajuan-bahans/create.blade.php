@extends('layouts.app')

@section('title')
    Tambah Pemakaian Obat dan Bahan
@endsection

@section('content')
    @push('css-plugins')
        <style>
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        </style>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

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
                                <h4 class="mb-sm-0">Tambah Pemakaian Obat dan Bahan</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Pemakaian
                                                Obat dan Bahan</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Tambah Pengajuan</a></li>
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

                            <div class="card">
                                <div class="card-body">

                                    @role('Admin Lab')
                                        <form action="{{ route('pengajuan-bahan.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <!-- Form data mahasiswa (nama, nim, kelas, dll) -->
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
                                                            <option value="">-- Pilih --</option>
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
                                                        <label for="tanggal_praktikum" class="form-label" style="font-size: 13px;">Tanggal Praktikum<span style="color: red;">*</span></label>
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
                                                        <label for="nama_praktikum" class="form-label" style="font-size: 13px;">Nama Praktikum<span style="color: red;">*</span></label>
                                                        <input type="text"
                                                            class="form-control @error('nama_praktikum') is-invalid @enderror" id="nama_praktikum" placeholder="Nama Mata Kuliah - Pertemuan Ke-"
                                                            name="nama_praktikum" value="{{ old('nama_praktikum') }}" required>
        
                                                        @error('nama_praktikum')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-size: 13px;">Tipe<span style="color: red;">*</span></th>
                                                                    <th style="font-size: 13px;">Nama Bahan/Obat<span style="color: red;">*</span></th>
                                                                    <th style="font-size: 13px;">Jumlah Pemakaian<span style="color: red;">*</span></th>
                                                                    <th style="font-size: 13px;">Satuan<span style="color: red;">*</span></th>
                                                                    <th style="font-size: 13px;">Keterangan</th>
                                                                    <th style="font-size: 13px;">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamic-form-container">
                                                                <tr class="dynamic-form">
                                                                    <td>
                                                                        <select class="form-control tipe-select" name="tipe[]" required>
                                                                            <option value="bahan">Bahan</option>
                                                                            <option value="obat">Obat</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <div class="bahan-dropdown">
                                                                            <select class="form-control bahan-select" name="bahan_id[]">
                                                                                <option value="">- Pilih -</option>
                                                                                @foreach ($bahans as $bahan)
                                                                                    <option value="{{ $bahan->id }}">
                                                                                        {{ $bahan->kode_bahan }} - {{ $bahan->nama_bahan }} ({{ $bahan->formula }}) - {{ $bahan->jenis_bahan }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="obat-dropdown d-none">
                                                                            <select class="form-control obat-select" name="obat_id[]">
                                                                                <option value="">- Pilih -</option>
                                                                                @foreach ($obats as $obat)
                                                                                    <option value="{{ $obat->id }}">
                                                                                        {{ $obat->kode_obat }} - {{ $obat->nama_obat }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <input type="number" class="form-control" name="jumlah_pemakaian[]" step="0.0001" min="0" required>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="satuan[]" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            <option value="ml">ml</option>
                                                                            <option value="mg">mg</option>
                                                                            <option value="gram">gram</option>
                                                                            <option value="tetes">tetes</option>
                                                                            <option value="tablet">tablet</option>
                                                                            <option value="kapsul">kapsul</option>
                                                                            <option value="kertas">kertas</option>
                                                                        </select>
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
                                                </div>

                                                <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ route('pengajuan-bahan.index') }}" class="btn btn-secondary"
                                                    onclick="return confirm('Apakah Anda yakin? Data yang Anda isi akan hilang.')">
                                                    Batal
                                                </a>
                                                <button type="submit" class="btn btn-primary mx-2">Simpan</button>
                                            </div>
                                        </form>
                                    @endrole

                                    @role('Mahasiswa')
                                        @if (Auth::user()->mahasiswa_id)
                                            <form action="{{ route('pengajuan-bahan.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">

                                                        <div class="mb-3">
                                                            <label for="anggota_kelompok" class="form-label" style="font-size: 13px;">
                                                                Nama Anggota Kelompok<span style="color: red;">*</span>
                                                            </label>
                                                            <input type="text" class="form-control" name="anggota_kelompok" 
                                                                value="{{ old('anggota_kelompok', ucwords(strtolower(Auth::user()->mahasiswa->nama_mahasiswa))) }}" 
                                                                placeholder="Contoh: Budi, Adam, Widya" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="nim_kelompok" class="form-label" style="font-size: 13px;">
                                                                NIM Ketua Kelompok<span style="color: red;">*</span>
                                                            </label>
                                                            <input type="text" class="form-control @error('nim_kelompok') is-invalid @enderror"
                                                                id="nim_kelompok" name="nim_kelompok"
                                                                value="{{ old('nim_kelompok', Auth::user()->mahasiswa->nim) }}" required>
                                                        
                                                            @error('nim_kelompok')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>                                                

                                                        <div class="mb-3">
                                                            <label for="kelas" class="form-label" style="font-size: 13px;">
                                                                Semester<span style="color: red;">*</span>
                                                            </label>
                                                            <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                                                id="kelas" name="kelas"
                                                                value="Semester {{ old('kelas', Auth::user()->mahasiswa->semester) }}" required readonly>
                                                        
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
                                                            <input type="datetime-local" class="form-control @error('tanggal_praktikum') is-invalid @enderror"
                                                                id="tanggal_praktikum" name="tanggal_praktikum" value="{{ old('tanggal_praktikum') }}" required>
                                                        
                                                            @error('tanggal_praktikum')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="nama_praktikum" class="form-label"
                                                                style="font-size: 13px;">Nama Praktikum<span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text"
                                                                class="form-control @error('nama_praktikum') is-invalid @enderror"
                                                                id="nama_praktikum"
                                                                placeholder="Nama Mata Kuliah - Pertemuan Ke-"
                                                                name="nama_praktikum" value="{{ old('nama_praktikum') }}"
                                                                required>

                                                            @error('nama_praktikum')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="font-size: 13px;">Tipe<span
                                                                                style="color: red;">*</span></th>
                                                                        <th style="font-size: 13px;">Nama Bahan/Obat<span
                                                                                style="color: red;">*</span></th>
                                                                        <th style="font-size: 13px;">Jumlah Pemakaian<span
                                                                                style="color: red;">*</span></th>
                                                                        <th style="font-size: 13px;">Satuan<span
                                                                                style="color: red;">*</span></th>
                                                                        <th style="font-size: 13px;">Keterangan</th>
                                                                        <th style="font-size: 13px;">Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="dynamic-form-container">
                                                                    <tr class="dynamic-form">
                                                                        <td>
                                                                            <select class="form-control tipe-select"
                                                                                name="tipe[]" required>
                                                                                <option value="bahan">Bahan</option>
                                                                                <option value="obat">Obat</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <div class="bahan-dropdown">
                                                                                <select class="form-control bahan-select"
                                                                                    name="bahan_id[]">
                                                                                    <option value="">- Pilih -</option>
                                                                                    @foreach ($bahans as $bahan)
                                                                                        <option value="{{ $bahan->id }}">
                                                                                            {{ $bahan->kode_bahan }} -
                                                                                            {{ $bahan->nama_bahan }}
                                                                                            ({{ $bahan->formula }}) -
                                                                                            {{ $bahan->jenis_bahan }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="obat-dropdown d-none">
                                                                                <select class="form-control obat-select"
                                                                                    name="obat_id[]">
                                                                                    <option value="">- Pilih -</option>
                                                                                    @foreach ($obats as $obat)
                                                                                        <option value="{{ $obat->id }}">
                                                                                            {{ $obat->kode_obat }} -
                                                                                            {{ $obat->nama_obat }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                name="jumlah_pemakaian[]" step="0.0001"
                                                                                min="0" required>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control" name="satuan[]"
                                                                                required>
                                                                                <option value="">- Pilih -</option>
                                                                                <option value="ml">ml</option>
                                                                                <option value="mg">mg</option>
                                                                                <option value="gram">gram</option>
                                                                                <option value="tetes">tetes</option>
                                                                                <option value="tablet">tablet</option>
                                                                                <option value="kapsul">kapsul</option>
                                                                                <option value="kertas">kertas</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="keterangan[]">
                                                                        </td>
                                                                        <td>
                                                                            <button type="button"
                                                                                class="btn btn-danger remove-form-btn"
                                                                                title="Hapus"><i
                                                                                    class="fas fa-trash-alt"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <button type="button" class="btn btn-success btn-sm mt-1"
                                                            id="add-form-btn">Tambah Baris</button>
                                                    </div>

                                                    <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('pengajuan-bahan.index') }}" class="btn btn-secondary"
                                                        onclick="return confirm('Apakah Anda yakin? Data yang Anda isi akan hilang.')">
                                                        Batal
                                                    </a>
                                                    <button type="submit" class="btn btn-primary mx-2">Simpan</button>
                                                </div>
                                            </form>
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
        $(document).ready(function() {
            function initSelect2() {
                $('.bahan-select, .obat-select').select2({
                    placeholder: "Pilih bahan atau obat",
                    allowClear: true
                });
            }
        
            initSelect2(); // Inisialisasi Select2 pertama kali
        
            $('#dynamic-form-container').on('change', '.tipe-select', function() {
                let row = $(this).closest('.dynamic-form');
                let bahanDropdown = row.find('.bahan-dropdown');
                let obatDropdown = row.find('.obat-dropdown');
        
                if ($(this).val() === 'bahan') {
                    bahanDropdown.removeClass('d-none');
                    obatDropdown.addClass('d-none');
                } else {
                    bahanDropdown.addClass('d-none');
                    obatDropdown.removeClass('d-none');
                }
            });
        
            $('#add-form-btn').on('click', function() {
                let firstRow = $('#dynamic-form-container .dynamic-form:first').clone();
        
                // Reset input dan select
                firstRow.find('input, select').val('');
                firstRow.find('.bahan-dropdown').removeClass('d-none');
                firstRow.find('.obat-dropdown').addClass('d-none');
        
                // Hapus event listener lama dan buat ulang Select2
                firstRow.find('.select2-container').remove(); // Menghapus instance lama
                firstRow.find('.bahan-select, .obat-select').removeClass('select2-hidden-accessible').next('.select2').remove();
                firstRow.find('.bahan-select, .obat-select').select2({
                    placeholder: "Pilih bahan atau obat",
                    allowClear: true
                });
        
                $('#dynamic-form-container').append(firstRow);
            });
        
            $('#dynamic-form-container').on('click', '.remove-form-btn', function() {
                if ($('#dynamic-form-container .dynamic-form').length > 1) {
                    $(this).closest('.dynamic-form').remove();
                } else {
                    alert('Minimal satu baris harus ada.');
                }
            });
        });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let now = new Date();
                let year = now.getFullYear();
                let month = String(now.getMonth() + 1).padStart(2, '0');
                let day = String(now.getDate()).padStart(2, '0');
                let hours = String(now.getHours()).padStart(2, '0');
                let minutes = String(now.getMinutes()).padStart(2, '0');

                let currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                document.getElementById("tanggal_praktikum").value = currentDateTime;
            });
        </script>

    @endpush
@endsection
