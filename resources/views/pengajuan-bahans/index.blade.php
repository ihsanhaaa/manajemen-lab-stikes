@extends('layouts.app')

@section('title')
    Pemakaian Obat dan Bahan Baru
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
                                    <h4 class="mb-sm-0">Data Pengajuan Baru ({{ $pengajuanbahans->count() }})</h4>
                                @endrole

                                @role('Admin Lab')
                                    <h4 class="mb-sm-0">Data Pengajuan Baru ({{ $pengajuanbahans->count() }})</h4>
                                @endrole

                                @role('Mahasiswa')
                                    <h4 class="mb-sm-0">Data Pemakaian Obat dan Bahan Saya</h4>
                                @endrole

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Pemakaian
                                                Obat dan Bahan</a></li>
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
                            <a href="{{ route('pengajuan-bahan.create') }}" class="btn btn-success btn-sm mb-3">
                                <i class="fas fa-plus"></i> Tambah Pemakaian Bahan
                            </a>

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
                                                <a class="nav-link" href="{{ route('pengajuan-selesai.index') }}">
                                                    <span class="d-block d-sm-none"><i class="fas fa-window-maximize"></i></span>
                                                    <span class="d-none d-sm-block">Pengajuan Selesai</span>
                                                </a>
                                            </li>
                                        </ul>
                                        
                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="pengajuanMahasiswa" role="tabpanel">

                                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                        @foreach ($pengajuanbahans as $key => $obat)
                                                            <tr>
                                                                <th scope="row">{{ ++$key }}</th>
                                                                <td> <a style="color: black"
                                                                        href="{{ route('pengajuan-bahan.show', $obat->id) }}">{{ $obat->nama_praktikum }}</a>
                                                                </td>
                                                                <td>
                                                                    <span style="cursor: pointer"
                                                                        title="{{ $obat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($obat->nama_mahasiswa, 30) }}</span>
                                                                </td>
                                                                <td title="{{ $obat->kelas }}" style="cursor: pointer">
                                                                    {{ \Carbon\Carbon::parse($obat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}
                                                                </td>
                                                                <td>
                                                                    @if ($obat->status == 0)
                                                                        <span class="badge bg-warning btn-sm">Belum di
                                                                            ACC</span>
                                                                    @else
                                                                        <span class="badge bg-success btn-sm">Sudah di
                                                                            ACC</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <a href="{{ route('pengajuan-bahan.show', $obat->id) }}"
                                                                            class="btn btn-success btn-sm"
                                                                            title="Lihat Detail"><i class="fas fa-eye"></i>
                                                                        </a>

                                                                        <form id="input"
                                                                            action="{{ route('pengajuan-bahan.destroy', $obat->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat atau bahan ini?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm mx-1"
                                                                                title="Hapus Data"><i
                                                                                    class="fas fa-trash-alt"></i></button>
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
                                                <a class="nav-link" href="{{ route('pengajuan-selesai.index') }}">
                                                    <span class="d-block d-sm-none"><i class="fas fa-window-maximize"></i></span>
                                                    <span class="d-none d-sm-block">Pengajuan Selesai</span>
                                                </a>
                                            </li>
                                        </ul>
                                        
                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="pengajuanMahasiswa" role="tabpanel">

                                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                        @foreach ($pengajuanbahans as $key => $obat)
                                                            <tr>
                                                                <th scope="row">{{ ++$key }}</th>
                                                                <td> <a style="color: black"
                                                                        href="{{ route('pengajuan-bahan.show', $obat->id) }}">{{ $obat->nama_praktikum }}</a>
                                                                </td>
                                                                <td>
                                                                    <span style="cursor: pointer"
                                                                        title="{{ $obat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($obat->nama_mahasiswa, 30) }}</span>
                                                                </td>
                                                                <td title="{{ $obat->kelas }}" style="cursor: pointer">
                                                                    {{ \Carbon\Carbon::parse($obat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}
                                                                </td>
                                                                <td>
                                                                    @if ($obat->status == 0)
                                                                        <span class="badge bg-warning btn-sm">Belum di
                                                                            ACC</span>
                                                                    @else
                                                                        <span class="badge bg-success btn-sm">Sudah di
                                                                            ACC</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <a href="{{ route('pengajuan-bahan.show', $obat->id) }}"
                                                                            class="btn btn-success btn-sm"
                                                                            title="Lihat Detail"><i class="fas fa-eye"></i>
                                                                        </a>

                                                                        <form id="input"
                                                                            action="{{ route('pengajuan-bahan.destroy', $obat->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat atau bahan ini?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm mx-1"
                                                                                title="Hapus Data"><i
                                                                                    class="fas fa-trash-alt"></i></button>
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

                                        @if (Auth::user()->mahasiswa_id)
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                    @foreach ($pengajuanbahans as $key => $obat)
                                                        @if ($obat->user_id == Auth::user()->id)
                                                            <tr>
                                                                <th scope="row">{{ ++$key }}</th>
                                                                <td> <a style="color: black"
                                                                        href="{{ route('pengajuan-bahan.show', $obat->id) }}">{{ $obat->nama_praktikum }}</a>
                                                                </td>
                                                                <td>
                                                                    <span style="cursor: pointer"
                                                                        title="{{ $obat->nama_mahasiswa }}">{{ \Illuminate\Support\Str::limit($obat->nama_mahasiswa, 30) }}</span>
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
                                                                        <a href="{{ route('pengajuan-bahan.show', $obat->id) }}"
                                                                            class="btn btn-success btn-sm" title="Lihat Detail"><i
                                                                                class="fas fa-eye"></i> </a>

                                                                        <form id="input"
                                                                            action="{{ route('pengajuan-bahan.destroy', $obat->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus pemakaian alat atau bahan ini?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm mx-1"
                                                                                title="Hapus Data"><i
                                                                                    class="fas fa-trash-alt"></i></button>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
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

                                    </div>
                                </div>
                                
                            @endrole

                        </div>
                    </div>
                    <!-- end row -->

                </div>

                <div id="feedback-container" style="position: fixed; bottom: 20px; right: 20px; width: 300px; z-index: 9999;">
                    <button id="toggle-feedback" style="background: #007bff; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;">
                        Saran
                    </button>
                
                    <div id="feedback-form" style="display: none; background: white; padding: 15px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); margin-top: 10px;">
                        <textarea id="feedback-text" placeholder="Masukkan saran Anda..." rows="4" style="width: 100%; padding: 5px;"></textarea>
                        <button id="send-feedback" style="margin-top: 10px; background: #28a745; color: white; border: none; padding: 10px; width: 100%; border-radius: 5px;">
                            Kirim
                        </button>
                    </div>
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
        document.getElementById('toggle-feedback').addEventListener('click', function() {
            var form = document.getElementById('feedback-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });

        document.getElementById('send-feedback').addEventListener('click', function() {
            var feedback = document.getElementById('feedback-text').value;
            var sendButton = document.getElementById('send-feedback');

            if (feedback.trim() === '') {
                alert('Silakan masukkan saran Anda.');
                return;
            }

            // Ubah tombol menjadi loading
            sendButton.innerHTML = 'Mengirim...';
            sendButton.disabled = true;

            fetch("{{ route('feedback.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ feedback: feedback })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                document.getElementById('feedback-text').value = '';

                // Kembalikan tombol ke normal
                sendButton.innerHTML = 'Kirim';
                sendButton.disabled = false;
            })
            .catch(error => {
                alert('Terjadi kesalahan, coba lagi.');

                // Kembalikan tombol ke normal
                sendButton.innerHTML = 'Kirim';
                sendButton.disabled = false;
            });
        });
        </script>

        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const formContainer = document.getElementById('dynamic-form-container');
                const addFormBtn = document.getElementById('add-form-btn');

                // Event Listener untuk perubahan tipe
                formContainer.addEventListener('change', function(event) {
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
                addFormBtn.addEventListener('click', function() {
                    const firstRow = formContainer.firstElementChild.cloneNode(true);

                    // Reset Nilai Input
                    firstRow.querySelectorAll('input, select').forEach(input => input.value = '');
                    firstRow.querySelector('.bahan-dropdown').classList.remove('d-none');
                    firstRow.querySelector('.obat-dropdown').classList.add('d-none');

                    formContainer.appendChild(firstRow);
                });

                // Hapus Baris
                formContainer.addEventListener('click', function(event) {
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
