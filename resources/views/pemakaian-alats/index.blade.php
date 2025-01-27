@extends('layouts.app')

@section('title')
    Data Pemakaian Alat
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
                                    <h4 class="mb-sm-0">Data Pemakaian Alat ({{ $pemakaianAlats->count() }})</h4>
                                @endrole

                                @role('Admin Lab')
                                    <h4 class="mb-sm-0">Data Pemakaian Alat ({{ $pemakaianAlats->count() }})</h4>
                                @endrole

                                @role('Mahasiswa')
                                    <h4 class="mb-sm-0">Data Pemakaian Alat Saya</h4>
                                @endrole

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Pemakaian Alat</a></li>
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
                            <div class="d-flex align-items-center mb-3">
                                <!-- Tombol Tambah Pengajuan Alat -->
                                <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                                    <i class="fas fa-plus"></i> Tambah Pengajuan Alat
                                </button>
                            
                                
                            </div>                            

                            <!-- Modal -->
                            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importModalLabel">Form Pemakaian Alat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        
                                        <form action="{{ route('pemakaian-alat.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- Form data mahasiswa -->
                                                <div class="mb-3">
                                                    <label for="anggota_kelompok" class="form-label" style="font-size: 13px;">Nama Anggota Kelompok<span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" name="anggota_kelompok" placeholder="Contoh: Budi, Adam, Widya" required>
                                                </div>
                                        
                                                <div class="mb-3">
                                                    <label for="nim_kelompok" class="form-label" style="font-size: 13px;">NIM Ketua Kelompok<span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" name="nim_kelompok" required>
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
                                                    <input type="datetime-local" class="form-control" name="tanggal_praktikum" required>
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
                                                                <th style="font-size: 13px;">Ukuran<span style="color: red;">*</span></th>
                                                                <th style="font-size: 13px;">Kondisi Pinjam<span style="color: red;">*</span></th>
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
                                                                    <select class="form-control" name="alat[]" required>
                                                                        <option value="">-- Pilih Alat --</option>
                                                                        @foreach($alats as $alat)
                                                                            <option value="{{ $alat->id }}">{{ $alat->nama_barang }} {{ $alat->ukuran }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <input type="text" class="form-control" name="ukuran[]" placeholder="contoh: Standar" required>
                                                                </td>

                                                                <td>
                                                                    <select class="form-control" name="kondisi_pinjam[]" required>
                                                                        <option value="">-- Pilih --</option>
                                                                        <option value="Baik">Baik</option>
                                                                        <option value="Pecah">Pecah</option>
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <input type="number" class="form-control" name="jumlah[]" required>
                                                                </td>

                                                                <td>
                                                                    <select class="form-control kondisi-kembali" name="kondisi_kembali[]" required>
                                                                        <option value="">-- Pilih --</option>
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
                                                        <th>Semester</th>
                                                        <th>Tanggal Pelaksanaan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $start = 0; @endphp
                                                        @foreach($pemakaianAlats as $key => $pemakaianAlat)
                                                                <tr>
                                                                    <th scope="row">{{ ++$start }}</th>
                                                                    <td> <a style="color: black" href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}">{{ $pemakaianAlat->nama_praktikum }}</a> </td>
                                                                    <td>
                                                                        <span style="cursor: pointer" title="{{ $pemakaianAlat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($pemakaianAlat->nama_mahasiswa, 30) }}</span>
                                                                    </td>
                                                                    <td>{{ $pemakaianAlat->kelas }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($pemakaianAlat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}</td>
                                                                    <td>
                                                                        @if ($pemakaianAlat->status == 0)
                                                                        <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                                        @else
                                                                        <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            <a href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
                
                                                                            <form id="input"
                                                                                action="{{ route('pemakaian-alat.destroy', $pemakaianAlat->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat ini?');">
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
                                                        <th>Semester</th>
                                                        <th>Tanggal Pelaksanaan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $start = 0; @endphp
                                                        @foreach($pemakaianAlatSelesais as $key => $pemakaianAlat)
                                                                <tr>
                                                                    <th scope="row">{{ ++$start }}</th>
                                                                    <td> <a style="color: black" href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}">{{ $pemakaianAlat->nama_praktikum }}</a> </td>
                                                                    <td>
                                                                        <span style="cursor: pointer" title="{{ $pemakaianAlat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($pemakaianAlat->nama_mahasiswa, 30) }}</span>
                                                                    </td>
                                                                    <td>{{ $pemakaianAlat->kelas }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($pemakaianAlat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}</td>
                                                                    <td>
                                                                        @if ($pemakaianAlat->status == 0)
                                                                        <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                                        @else
                                                                        <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @role('Admin Lab')
                                                                            @if ($pemakaianAlat->status == 0)
                                                                                <form action="{{ route('pengajuan-bahan.konfirmasi.update', $pemakaianAlat->id) }}" method="post"
                                                                                    onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                                                    @csrf
                                                                                    <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                                                </form>
                                                                            @endif
                                                                        @endrole
                                                                        <div class="d-flex">
                                                                            <a href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
                
                                                                            <form id="input"
                                                                                action="{{ route('pemakaian-alat.destroy', $pemakaianAlat->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat ini?');">
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
                                                        <th>Semester</th>
                                                        <th>Tanggal Pelaksanaan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $start = 0; @endphp
                                                        @foreach($pemakaianAlats as $key => $pemakaianAlat)
                                                                <tr>
                                                                    <th scope="row">{{ ++$start }}</th>
                                                                    <td> <a style="color: black" href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}">{{ $pemakaianAlat->nama_praktikum }}</a> </td>
                                                                    <td>
                                                                        <span style="cursor: pointer" title="{{ $pemakaianAlat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($pemakaianAlat->nama_mahasiswa, 30) }}</span>
                                                                    </td>
                                                                    <td>{{ $pemakaianAlat->kelas }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($pemakaianAlat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}</td>
                                                                    <td>
                                                                        @if ($pemakaianAlat->status == 0)
                                                                        <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                                        @else
                                                                        <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{-- @role('Admin Lab')
                                                                            @if ($pemakaianAlat->status == 0)
                                                                                <form action="{{ route('pengajuan-bahan.konfirmasi.update', $pemakaianAlat->id) }}" method="post"
                                                                                    onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                                                    @csrf
                                                                                    <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                                                </form>
                                                                            @endif
                                                                        @endrole --}}
                                                                        <div class="d-flex">
                                                                            <a href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
                
                                                                            <form id="input"
                                                                                action="{{ route('pemakaian-alat.destroy', $pemakaianAlat->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat ini?');">
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
                                                        <th>Semester</th>
                                                        <th>Tanggal Pelaksanaan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $start = 0; @endphp
                                                        @foreach($pemakaianAlatSelesais as $key => $pemakaianAlat)
                                                                <tr>
                                                                    <th scope="row">{{ ++$start }}</th>
                                                                    <td> <a style="color: black" href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}">{{ $pemakaianAlat->nama_praktikum }}</a> </td>
                                                                    <td>
                                                                        <span style="cursor: pointer" title="{{ $pemakaianAlat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($pemakaianAlat->nama_mahasiswa, 30) }}</span>
                                                                    </td>
                                                                    <td>{{ $pemakaianAlat->kelas }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($pemakaianAlat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}</td>
                                                                    <td>
                                                                        @if ($pemakaianAlat->status == 0)
                                                                        <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                                        @else
                                                                        <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{-- @role('Admin Lab')
                                                                            @if ($pemakaianAlat->status == 0)
                                                                                <form action="{{ route('pengajuan-bahan.konfirmasi.update', $pemakaianAlat->id) }}" method="post"
                                                                                    onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                                                    @csrf
                                                                                    <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                                                </form>
                                                                            @endif
                                                                        @endrole --}}
                                                                        <div class="d-flex">
                                                                            <a href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
                
                                                                            <form id="input"
                                                                                action="{{ route('pemakaian-alat.destroy', $pemakaianAlat->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat ini?');">
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
                                                <th>Semester</th>
                                                <th>Tanggal Pelaksanaan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @php $start = 0; @endphp
                                                @foreach($pemakaianAlats as $key => $pemakaianAlat)
                                                    @if ($pemakaianAlat->user_id == Auth::user()->id)
                                                        <tr>
                                                            <th scope="row">{{ ++$start }}</th>
                                                            <td> <a style="color: black" href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}">{{ $pemakaianAlat->nama_praktikum }}</a> </td>
                                                            <td>
                                                                <span style="cursor: pointer" title="{{ $pemakaianAlat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($pemakaianAlat->nama_mahasiswa, 30) }}</span>
                                                            </td>
                                                            <td>{{ $pemakaianAlat->kelas }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($pemakaianAlat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}</td>
                                                            <td>
                                                                @if ($pemakaianAlat->status == 0)
                                                                <span class="badge bg-warning btn-sm">Belum di ACC</span>
                                                                @else
                                                                <span class="badge bg-success btn-sm">Sudah di ACC</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @role('Admin Lab')
                                                                    @if ($pemakaianAlat->status == 0)
                                                                        <form action="{{ route('pengajuan-bahan.konfirmasi.update', $pemakaianAlat->id) }}" method="post"
                                                                            onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                                            @csrf
                                                                            <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                                        </form>
                                                                    @endif
                                                                @endrole
                                                                <div class="d-flex">
                                                                    <a href="{{ route('pemakaian-alat.show', $pemakaianAlat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
        
                                                                    <form id="input"
                                                                        action="{{ route('pemakaian-alat.destroy', $pemakaianAlat->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat ini?');">
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

            // Tambahkan Baris Baru
            addFormBtn.addEventListener('click', function () {
                const newForm = document.querySelector('.dynamic-form').cloneNode(true);
                newForm.querySelectorAll('input, select').forEach((input) => {
                    input.value = '';
                    input.removeAttribute('id'); // Hapus ID duplikat
                });
                formContainer.appendChild(newForm);
            });

            // Hapus Baris
            formContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-form-btn')) {
                    const formRow = e.target.closest('.dynamic-form');
                    if (formContainer.childElementCount > 1) {
                        formRow.remove();
                    } else {
                        alert('Minimal satu baris harus ada.');
                    }
                }
            });

            // Event Listener untuk Kondisi Kembali
            document.addEventListener('change', function (event) {
                if (event.target.matches('.kondisi-kembali')) {
                    const kondisi = event.target.value;
                    const jumlahRusakInput = event.target.closest('tr').querySelector('.jumlah-rusak');

                    if (kondisi === 'Baik') {
                        jumlahRusakInput.value = 0;
                        jumlahRusakInput.readOnly = true;
                    } else if (kondisi === 'Pecah') {
                        jumlahRusakInput.value = '';
                        jumlahRusakInput.readOnly = false;
                    }
                }
            });
        });

    </script>
    
    @endpush
@endsection