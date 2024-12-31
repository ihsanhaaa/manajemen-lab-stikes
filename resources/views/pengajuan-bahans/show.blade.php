@extends('layouts.app')

@section('title')
    Detail Pemakaian Bahan
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
                                <strong>Alert!</strong> {{ $message }}.
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
                                    <h4 class="mb-sm-0">Detail Pemakaian Bahan</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item">Pemakaian Bahan</li>
                                            <li class="breadcrumb-item active">Detail Pemakaian Bahan</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        @role('Admin Lab')
                            <form action="{{ route('pengajuan-bahan.destroy', $pengajuanBahan->id) }}"
                                method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data pengajuan bahan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mb-3"><i class="fas fa-trash-alt"></i> Hapus Data Pemakaian Bahan</button>
                            </form>
                        @endrole

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="mb-3"> <i class="fas fa-book"></i> {{ $pengajuanBahan->nama_praktikum }} </h2>
                                        
                                        <div class="row">
                                            <div class="col">
                                                <p><strong>Tanggal Pelaksanaan:</strong> {{ $pengajuanBahan->tanggal_pelaksanaan }}</p>
                                                <p><strong>Nama Anggota Kelompok:</strong> {{ $pengajuanBahan->nama_mahasiswa }}</p>
                                                <p><strong>NIM Ketua Kelompok:</strong> {{ $pengajuanBahan->kelompok ?? 'N/A' }}</p>
                                                <p><strong>Kelas:</strong> {{ $pengajuanBahan->kelas ?? 'N/A' }}</p>
                                            </div>

                                            <div class="col">
                                                <p><strong>Dibuat pada:</strong> {{ $pengajuanBahan->created_at }}</p>
                                                <p><i class="fas fa-user"></i> {{ $pengajuanBahan->user->name }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex">
                                            @if ($pengajuanBahan->status == 0)
                                                @role('Admin Lab')
                                                    <form action="{{ route('pengajuan-bahan.konfirmasi.update', $pengajuanBahan->id) }}" method="post"
                                                        onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                        @csrf
                                                        <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                    </form>
                                                @endrole

                                                @role('Ketua STIKes')
                                                    <form action="{{ route('pengajuan-bahan.konfirmasi.update', $pengajuanBahan->id) }}" method="post"
                                                        onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                        @csrf
                                                        <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                    </form>
                                                @endrole
                                            @else
                                                <button class="btn btn-success btn-sm" disabled><i class="fas fa-check-circle"></i> Sudah ACC</button>
                                            @endif

                                            @role('Admin Lab')
                                                @if ($pengajuanBahan->status == 0)
                                                    <button type="button" class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editModal">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </button>
                                                @else
                                                    <button class="btn btn-primary btn-sm mx-1" disabled><i class="fas fa-check-circle"></i> Edit Data</button>
                                                @endif
                                            @endrole

                                            <!-- Modal -->
                                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Data Pemakaian Bahan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('pengajuan-bahan.updateDetail', $pengajuanBahan->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nama_mahasiswa" class="form-label">Nama Kelompok</label>
                                                                    <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ $pengajuanBahan->nama_mahasiswa }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="kelompok" class="form-label">NIM Ketua Kelompok</label>
                                                                    <input type="text" class="form-control" id="kelompok" name="kelompok" value="{{ $pengajuanBahan->kelompok }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="kelas" class="form-label">Semester</label>
                                                                    <select class="form-control" id="kelas" name="kelas" required>
                                                                        <option value="">-- Pilih Semester --</option>
                                                                        <option value="Semester 3" {{ $pengajuanBahan->kelas == 'Semester 3' ? 'selected' : '' }}>Semester 3</option>
                                                                        <option value="Semester 4" {{ $pengajuanBahan->kelas == 'Semester 4' ? 'selected' : '' }}>Semester 4</option>
                                                                        <option value="Semester 5" {{ $pengajuanBahan->kelas == 'Semester 5' ? 'selected' : '' }}>Semester 5</option>
                                                                        <option value="Semester 6" {{ $pengajuanBahan->kelas == 'Semester 6' ? 'selected' : '' }}>Semester 6</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="tanggal_pelaksanaan" class="form-label">Tanggal Praktikum</label>
                                                                    <input type="datetime-local" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="{{ $pengajuanBahan->tanggal_pelaksanaan }}">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="nama_praktikum" class="form-label">Nama Praktikum</label>
                                                                    <input type="text" class="form-control" id="nama_praktikum" name="nama_praktikum" value="{{ $pengajuanBahan->nama_praktikum }}">
                                                                </div>

                                                                <h5>Pemakaian Bahan/Obat</h5>
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Tipe</th>
                                                                            <th>Nama Bahan/Obat</th>
                                                                            <th>Jumlah Pemakaian</th>
                                                                            <th>Satuan</th>
                                                                            <th>Jenis Bahan/Obat</th>
                                                                            <th>Keterangan</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($pengajuanBahan->obatPengajuanBahans as $key => $obatPengajuanBahan)
                                                                        {{-- {{ dd($obatPengajuanBahan->bahan->nama_bahan) }} --}}
                                                                            <tr>
                                                                                <td>
                                                                                    <select class="form-control tipe-select" name="obatPengajuanBahans[{{ $key }}][tipe]" data-key="{{ $key }}" required>
                                                                                        <option value="bahan" {{ $obatPengajuanBahan->tipe == 'bahan' ? 'selected' : '' }}>Bahan</option>
                                                                                        <option value="obat" {{ $obatPengajuanBahan->tipe == 'obat' ? 'selected' : '' }}>Obat</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control pilihan-select" name="obatPengajuanBahans[{{ $key }}][obat_bahan_id]" id="pilihan-{{ $key }}" required>
                                                                                        @if($obatPengajuanBahan->tipe == 'bahan')
                                                                                            @foreach($bahans as $bahan)
                                                                                                <option value="{{ $bahan->id }}" {{ $obatPengajuanBahan->bahan_id == $bahan->id ? 'selected' : '' }}>
                                                                                                    {{ $bahan->kode_bahan }} - {{ $bahan->nama_bahan }}:{{ $bahan->formula }} ({{ $bahan->jenis_bahan }})
                                                                                                </option>
                                                                                            @endforeach
                                                                                        @else
                                                                                            @foreach($obats as $obat)
                                                                                                <option value="{{ $obat->id }}" {{ $obatPengajuanBahan->obat_id == $obat->id ? 'selected' : '' }}>
                                                                                                    {{ $obat->kode_obat }} - {{ $obat->nama_obat }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input 
                                                                                        type="number" 
                                                                                        class="form-control"
                                                                                        name="obatPengajuanBahans[{{ $key }}][jumlah_pemakaian]"
                                                                                        step="0.0001" 
                                                                                        min="0"
                                                                                        value="{{ $obatPengajuanBahan->jumlah_pemakaian }}"
                                                                                        title="Masukkan angka desimal hingga 4 angka di belakang koma, contoh: 0.0000 atau 123.4567" 
                                                                                        required
                                                                                    >
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control" name="obatPengajuanBahans[{{ $key }}][satuan]" required>
                                                                                        <option value="">-- Pilih Satuan --</option>
                                                                                        <option value="ml" {{ $obatPengajuanBahan->satuan == 'ml' ? 'selected' : '' }}>ml</option>
                                                                                        <option value="mg" {{ $obatPengajuanBahan->satuan == 'mg' ? 'selected' : '' }}>mg</option>
                                                                                        <option value="gram" {{ $obatPengajuanBahan->satuan == 'gram' ? 'selected' : '' }}>gram</option>
                                                                                        <option value="tetes" {{ $obatPengajuanBahan->satuan == 'tetes' ? 'selected' : '' }}>tetes</option>
                                                                                        <option value="tablet" {{ $obatPengajuanBahan->satuan == 'tablet' ? 'selected' : '' }}>tablet</option>
                                                                                        <option value="kapsul" {{ $obatPengajuanBahan->satuan == 'kapsul' ? 'selected' : '' }}>kapsul</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control" name="obatPengajuanBahans[{{ $key }}][jenis_obat]" required>
                                                                                        <option value="">-- Pilih Jenis Obat --</option>
                                                                                        <option value="Cair" {{ $obatPengajuanBahan->jenis_obat == 'Cair' ? 'selected' : '' }}>Cair</option>
                                                                                        <option value="Padat" {{ $obatPengajuanBahan->jenis_obat == 'Padat' ? 'selected' : '' }}>Padat</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="obatPengajuanBahans[{{ $key }}][keterangan]" value="{{ $obatPengajuanBahan->keterangan }}">
                                                                                </td>
                                                                                <input type="hidden" name="obatPengajuanBahans[{{ $key }}][id]" value="{{ $obatPengajuanBahan->id }}">
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        @if ($pengajuanBahan->status != 0)
                                            <div class="alert alert-primary mt-3" role="alert">
                                                Data yang sudah di ACC tidak bisa diedit atau dihapus!
                                            </div>
                                        @endif

                                        <hr>

                                        <h3>Pemakaian Bahan</h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Nama Bahan/Obat</th>
                                                    <th>Tipe</th>
                                                    <th>Jumlah Pemakaian</th>
                                                    <th>Satuan</th>
                                                    <th>Jenis</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pengajuanBahan->obatPengajuanBahans as $obatPengajuanBahan)
                                                    @if($obatPengajuanBahan->tipe == 'bahan')
                                                        <tr>
                                                            <td><a href="{{ route('data-bahan.show', $obatPengajuanBahan->bahan->id) }}">{{ $obatPengajuanBahan->bahan->kode_bahan ?? 'N/A' }}</a></td>
                                                            <td>{{ $obatPengajuanBahan->bahan->nama_bahan ?? 'N/A' }} ({{ $obatPengajuanBahan->bahan->formula }})</td>
                                                            <td>{{ $obatPengajuanBahan->tipe ?? 'N/A' }} - {{ $obatPengajuanBahan->bahan->jenis_bahan ?? 'N/A' }}</td>
                                                            <td>{{ $obatPengajuanBahan->jumlah_pemakaian }}</td>
                                                            <td>{{ $obatPengajuanBahan->satuan ?? 'N/A' }}</td>
                                                            <td>{{ $obatPengajuanBahan->jenis_obat }}</td>
                                                            <td>{{ $obatPengajuanBahan->keterangan }}</td>
                                                            <td>
                                                                @if ($pengajuanBahan->status == 0)
                                                                    <form action="{{ route('destroyPengajuanObatBahan', $obatPengajuanBahan->id) }}"
                                                                        method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm mb-3" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                @else
                                                                    <button class="btn btn-danger btn-sm mx-1" title="Data yang sudah di ACC tidak bisa dihapus" disabled><i class="fas fa-trash-alt"></i> </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @elseif($obatPengajuanBahan->tipe == 'obat')
                                                        <tr>
                                                            <td><a href="{{ route('data-obat.show', $obatPengajuanBahan->obat->id) }}">{{ $obatPengajuanBahan->obat->kode_obat ?? 'N/A' }}</a></td>
                                                            <td>{{ $obatPengajuanBahan->obat->nama_obat ?? 'N/A' }}</td>
                                                            <td>{{ $obatPengajuanBahan->tipe ?? 'N/A' }}</td>
                                                            <td>{{ $obatPengajuanBahan->jumlah_pemakaian }}</td>
                                                            <td>{{ $obatPengajuanBahan->satuan ?? 'N/A' }}</td>
                                                            <td>{{ $obatPengajuanBahan->jenis_obat }}</td>
                                                            <td>{{ $obatPengajuanBahan->keterangan }}</td>
                                                            <td>
                                                                @if ($pengajuanBahan->status == 0)
                                                                    <form action="{{ route('destroyPengajuanObatBahan', $obatPengajuanBahan->id) }}"
                                                                        method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm mb-3" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                @else
                                                                    <button class="btn btn-danger btn-sm mx-1" title="Data yang sudah di ACC tidak bisa dihapus" disabled><i class="fas fa-trash-alt"></i> </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
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
                const bahanOptions = @json($bahans);
                const obatOptions = @json($obats);

                document.querySelectorAll('.tipe-select').forEach(select => {
                    select.addEventListener('change', function () {
                        const key = this.dataset.key;
                        const pilihanSelect = document.getElementById(`pilihan-${key}`);
                        pilihanSelect.innerHTML = ''; // Kosongkan pilihan sebelumnya
                        
                        if (this.value === 'bahan') {
                            bahanOptions.forEach(bahan => {
                                const option = document.createElement('option');
                                option.value = bahan.id;
                                option.textContent = `${bahan.kode_bahan} - ${bahan.nama_bahan}`;
                                pilihanSelect.appendChild(option);
                            });
                        } else if (this.value === 'obat') {
                            obatOptions.forEach(obat => {
                                const option = document.createElement('option');
                                option.value = obat.id;
                                option.textContent = `${obat.kode_obat} - ${obat.nama_obat}`;
                                pilihanSelect.appendChild(option);
                            });
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection