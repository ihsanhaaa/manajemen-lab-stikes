@extends('layouts.app')

@section('title')
    Data Pemakaian Obat dan Bahan
@endsection

@section('content')
    @push('css-plugins')
        <style>
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        </style>
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
                                @role('Ketua STIKes')
                                    <h4 class="mb-sm-0">Data Pemakaian Obat dan Bahan ({{ $pengajuanbahans->count() }})</h4>
                                @endrole

                                @role('Admin Lab')
                                    <h4 class="mb-sm-0">Data Pemakaian Obat dan Bahan ({{ $pengajuanbahans->count() }})</h4>
                                @endrole

                                @role('Mahasiswa')
                                    <h4 class="mb-sm-0">Data Pemakaian Obat dan Bahan Saya</h4>
                                @endrole

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Pemakaian Obat dan Bahan</a></li>
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
                                <i class="fas fa-plus"></i> Tambah Pemakaian Bahan
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
                                                                    <th style="font-size: 13px;">Jenis<span style="color: red;">*</span></th>
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
                                                                                <option value="">-- Pilih --</option>
                                                                                @foreach($bahans as $bahan)
                                                                                <option value="{{ $bahan->id }}">{{ $bahan->kode_bahan }} - {{ $bahan->nama_bahan }} ({{ $bahan->formula }}) - {{ $bahan->jenis_bahan }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="obat-dropdown d-none">
                                                                            <select class="form-control obat-select" name="obat_id[]">
                                                                                <option value="">-- Pilih --</option>
                                                                                @foreach($obats as $obat)
                                                                                <option value="{{ $obat->id }}">{{ $obat->kode_obat }} - {{ $obat->nama_obat }}</option>
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
                                                                        <select class="form-control" name="jenis_obat[]" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            <option value="Cair">Cair</option>
                                                                            <option value="Padat">Padat</option>
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
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @role('Ketua STIKes')
                                <div class="card">
                                    <div class="card-body">

                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#pengajuanMahasiswa" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-tint"></i></span>
                                            <span class="d-none d-sm-block">Pengajuan Baru</span> 
                                            </a>
                                            </li>
                                            <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#pengajuanMahasiswaSelesai" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-window-maximize"></i></span>
                                            <span class="d-none d-sm-block">Pengajuan Selesai</span> 
                                            </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="pengajuanMahasiswa" role="tabpanel">

                                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Praktikum</th>
                                                        <th>Anggota Kelompok</th>
                                                        <th>Tanggal Pelaksanaan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($pengajuanbahans as $key => $obat)
                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td> <a href="{{ route('pengajuan-bahan.show', $obat->id) }}">{{ $obat->nama_praktikum }}</a> </td>
                                                        <td>
                                                            <span style="cursor: pointer" title="{{ $obat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($obat->nama_mahasiswa, 30) }}</span>
                                                        </td>
                                                        <td title="{{ $obat->kelas }}" style="cursor: pointer">
                                                            {{ \Carbon\Carbon::parse($obat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}
                                                        </td>
                                                        <td>
                                                            @if ($obat->status == 0)
                                                            <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                            @else
                                                            <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="{{ route('pengajuan-bahan.show', $obat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
            
                                                                <form id="input"
                                                                    action="{{ route('pengajuan-bahan.destroy', $obat->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat atau bahan ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="tab-pane" id="pengajuanMahasiswaSelesai" role="tabpanel">

                                                <table id="datatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Praktikum</th>
                                                        <th>Anggota Kelompok</th>
                                                        <th>Tanggal Pelaksanaan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($pengajuanbahanSelesais as $key => $obat)
                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td> <a href="{{ route('pengajuan-bahan.show', $obat->id) }}">{{ $obat->nama_praktikum }}</a> </td>
                                                        <td>
                                                            <span style="cursor: pointer" title="{{ $obat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($obat->nama_mahasiswa, 30) }}</span>
                                                        </td>
                                                        <td title="{{ $obat->kelas }}" style="cursor: pointer">
                                                            {{ \Carbon\Carbon::parse($obat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}
                                                        </td>
                                                        <td>
                                                            @if ($obat->status == 0)
                                                            <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                            @else
                                                            <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @role('Admin Lab')
                                                                    @if ($obat->status == 0)
                                                                    <form action="{{ route('pengajuan-bahan.konfirmasi.update', $obat->id) }}" method="post"
                                                                        onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                                        @csrf
                                                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                                    </form>
                                                                    @endif
                                                                @endrole
                                                                <a href="{{ route('pengajuan-bahan.show', $obat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
            
                                                                <form id="input"
                                                                    action="{{ route('pengajuan-bahan.destroy', $obat->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat atau bahan ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                </div> 
                            @endrole

                            @role('Admin Lab')
                                <div class="card">
                                    <div class="card-body">

                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#pengajuanMahasiswa" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-tint"></i></span>
                                            <span class="d-none d-sm-block">Pengajuan Baru</span> 
                                            </a>
                                            </li>
                                            <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#pengajuanMahasiswaSelesai" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-window-maximize"></i></span>
                                            <span class="d-none d-sm-block">Pengajuan Selesai</span> 
                                            </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="pengajuanMahasiswa" role="tabpanel">

                                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Praktikum</th>
                                                        <th>Anggota Kelompok</th>
                                                        <th>Tanggal Pelaksanaan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($pengajuanbahans as $key => $obat)
                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td> <a href="{{ route('pengajuan-bahan.show', $obat->id) }}">{{ $obat->nama_praktikum }}</a> </td>
                                                        <td>
                                                            <span style="cursor: pointer" title="{{ $obat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($obat->nama_mahasiswa, 30) }}</span>
                                                        </td>
                                                        <td title="{{ $obat->kelas }}" style="cursor: pointer">
                                                            {{ \Carbon\Carbon::parse($obat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}
                                                        </td>
                                                        <td>
                                                            @if ($obat->status == 0)
                                                            <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                            @else
                                                            <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="{{ route('pengajuan-bahan.show', $obat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
            
                                                                <form id="input"
                                                                    action="{{ route('pengajuan-bahan.destroy', $obat->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat atau bahan ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="tab-pane" id="pengajuanMahasiswaSelesai" role="tabpanel">

                                                <table id="datatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Praktikum</th>
                                                        <th>Anggota Kelompok</th>
                                                        <th>Tanggal Pelaksanaan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($pengajuanbahanSelesais as $key => $obat)
                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td> <a href="{{ route('pengajuan-bahan.show', $obat->id) }}">{{ $obat->nama_praktikum }}</a> </td>
                                                        <td>
                                                            <span style="cursor: pointer" title="{{ $obat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($obat->nama_mahasiswa, 30) }}</span>
                                                        </td>
                                                        <td title="{{ $obat->kelas }}" style="cursor: pointer">
                                                            {{ \Carbon\Carbon::parse($obat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}
                                                        </td>
                                                        <td>
                                                            @if ($obat->status == 0)
                                                            <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                            @else
                                                            <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @role('Admin Lab')
                                                                    @if ($obat->status == 0)
                                                                    <form action="{{ route('pengajuan-bahan.konfirmasi.update', $obat->id) }}" method="post"
                                                                        onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                                        @csrf
                                                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                                    </form>
                                                                    @endif
                                                                @endrole
                                                                <a href="{{ route('pengajuan-bahan.show', $obat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
            
                                                                <form id="input"
                                                                    action="{{ route('pengajuan-bahan.destroy', $obat->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat atau bahan ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                </div> 
                            @endrole

                            @role('Mahasiswa')
                                <div class="card">
                                    <div class="card-body">

                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Praktikum</th>
                                                <th>Anggota Kelompok</th>
                                                <th>Tanggal Pelaksanaan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pengajuanbahans as $key => $obat)
                                                    @if ($obat->user_id == Auth::user()->id)
                                                        <tr>
                                                            <th scope="row">{{ ++$key }}</th>
                                                            <td> <a href="{{ route('pengajuan-bahan.show', $obat->id) }}">{{ $obat->nama_praktikum }}</a> </td>
                                                            <td>
                                                                <span style="cursor: pointer" title="{{ $obat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($obat->nama_mahasiswa, 30) }}</span>
                                                            </td>
                                                            <td title="{{ $obat->kelas }}" style="cursor: pointer">
                                                                {{ \Carbon\Carbon::parse($obat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}
                                                            </td>
                                                            <td>
                                                                @if ($obat->status == 0)
                                                                <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                                @else
                                                                <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <a href="{{ route('pengajuan-bahan.show', $obat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
                
                                                                    <form id="input"
                                                                        action="{{ route('pengajuan-bahan.destroy', $obat->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat atau bahan ini?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div> 
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
            document.addEventListener('DOMContentLoaded', function () {
                const formContainer = document.getElementById('dynamic-form-container');
                const addFormBtn = document.getElementById('add-form-btn');

                // Event Listener untuk perubahan tipe
                formContainer.addEventListener('change', function (event) {
                    if (event.target.classList.contains('tipe-select')) {
                        const row = event.target.closest('.dynamic-form');
                        const bahanDropdown = row.querySelector('.bahan-dropdown');
                        const obatDropdown = row.querySelector('.obat-dropdown');

                        if (event.target.value === 'bahan') {
                            bahanDropdown.classList.remove('d-none');
                            obatDropdown.classList.add('d-none');
                        } else {
                            bahanDropdown.classList.add('d-none');
                            obatDropdown.classList.remove('d-none');
                        }
                    }
                });

                // Tambah Baris Baru
                addFormBtn.addEventListener('click', function () {
                    const firstRow = formContainer.firstElementChild.cloneNode(true);

                    // Reset Nilai Input
                    firstRow.querySelectorAll('input, select').forEach(input => input.value = '');
                    firstRow.querySelector('.bahan-dropdown').classList.remove('d-none');
                    firstRow.querySelector('.obat-dropdown').classList.add('d-none');

                    formContainer.appendChild(firstRow);
                });

                // Hapus Baris
                formContainer.addEventListener('click', function (event) {
                    if (event.target.classList.contains('remove-form-btn')) {
                        const row = event.target.closest('.dynamic-form');
                        if (formContainer.childElementCount > 1) {
                            row.remove();
                        } else {
                            alert('Minimal satu baris harus ada.');
                        }
                    }
                });
            });


        </script>
    
    @endpush
@endsection