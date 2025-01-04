@extends('layouts.app')

@section('title')
    Detail Pemakaian Alat
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
                                    <h4 class="mb-sm-0">Detail Pemakaian Alat</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item">Pemakaian Alat</li>
                                            <li class="breadcrumb-item active">Detail Pemakaian Alat</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        @role('Admin Lab')
                            <form action="{{ route('pemakaian-alat.destroy', $pemakaianAlat->id) }}"
                                method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data pengajuan bahan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mb-3"><i class="fas fa-trash-alt"></i> Hapus Data Pemakaian Alat</button>
                            </form>
                        @endrole

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="mb-3"> <i class="fas fa-book"></i> {{ $pemakaianAlat->nama_praktikum }} </h2>
                                        
                                        <div class="row">
                                            <div class="col">
                                                <p><strong>Waktu Praktikum:</strong> {{ \Carbon\Carbon::parse($pemakaianAlat->tanggal_pelaksanaan)->format('d/m/Y - H:i') }}</p>
                                                <p><strong>Nama Anggota Kelompok:</strong> {{ $pemakaianAlat->nama_mahasiswa }}</p>
                                                <p><strong>NIM Ketua Kelompok:</strong> {{ $pemakaianAlat->nim_kelompok ?? 'N/A' }}</p>
                                                <p><strong>Semester:</strong> {{ $pemakaianAlat->kelas ?? 'N/A' }}</p>
                                            </div>

                                            <div class="col">
                                                <p><strong>Dibuat pada:</strong> {{ $pemakaianAlat->created_at }}</p>

                                                <p><i class="fas fa-user"></i> {{ $pemakaianAlat->user->name }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex">
                                            @if ($pemakaianAlat->status == 0)
                                                @role('Admin Lab')
                                                    <form action="{{ route('pemakaian-alat.konfirmasi.update', $pemakaianAlat->id) }}" method="post"
                                                        onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                    </form>
                                                @endrole

                                                @role('Ketua STIKes')
                                                    <form action="{{ route('pemakaian-alat.konfirmasi.update', $pemakaianAlat->id) }}" method="post"
                                                        onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi ini?')">
                                                        @csrf
                                                        <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> ACC Sekarang</button>
                                                    </form>
                                                @endrole
                                            @else
                                                <button class="btn btn-success btn-sm" disabled><i class="fas fa-check-circle"></i> Sudah ACC</button>
                                            @endif

                                            @role('Admin Lab')
                                                @if ($pemakaianAlat->status == 0)
                                                    <button type="button" class="btn btn-secondary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                                        <i class="fas fa-plus"></i> Tambah Data
                                                    </button>
                                                    
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </button>
                                                @else
                                                    <button class="btn btn-primary btn-sm mx-1" disabled><i class="fas fa-check-circle"></i> Tidak Bisa Diedit Karena Sudah Di ACC</button>
                                                @endif
                                            @endrole
                                        </div>
                                        
                                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('pemakaian-alat.updateDetail', $pemakaianAlat->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Data Pemakaian Alat</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form data mahasiswa -->
                                                            <div class="mb-3">
                                                                <label for="nama_mahasiswa" class="form-label">Nama Anggota Kelompok</label>
                                                                <input type="text" class="form-control" name="nama_mahasiswa" value="{{ $pemakaianAlat->nama_mahasiswa }}" required>
                                                            </div>
                                        
                                                            <div class="mb-3">
                                                                <label for="nim_kelompok" class="form-label">NIM Ketua Kelompok</label>
                                                                <input type="text" class="form-control" name="nim_kelompok" value="{{ $pemakaianAlat->nim_kelompok }}">
                                                            </div>
                                        
                                                            <div class="mb-3">
                                                                <label for="kelas" class="form-label">Semester</label>
                                                                <select class="form-control" name="kelas" required>
                                                                    <option value="Semester 3" {{ $pemakaianAlat->kelas == 'Semester 3' ? 'selected' : '' }}>Semester 3</option>
                                                                    <option value="Semester 4" {{ $pemakaianAlat->kelas == 'Semester 4' ? 'selected' : '' }}>Semester 4</option>
                                                                    <option value="Semester 5" {{ $pemakaianAlat->kelas == 'Semester 5' ? 'selected' : '' }}>Semester 5</option>
                                                                    <option value="Semester 6" {{ $pemakaianAlat->kelas == 'Semester 6' ? 'selected' : '' }}>Semester 6</option>
                                                                </select>
                                                            </div>

                                                            <hr>
                                        
                                                            <!-- Dinamis Form -->
                                                            <h5 class="mb-3 mt-3">Data Alat</h5>
                                                            <div id="dynamic-form-container">
                                                                @foreach($pemakaianAlat->formPemakaianAlats as $index => $formPemakaianAlat)
                                                                <div class="row dynamic-form mb-3">
                                                                    <div class="col-md-2">
                                                                        <label for="alat[]" class="form-label">Nama Barang</label>
                                                                        <select class="form-control" name="alat[]">
                                                                            @foreach($alats as $alat)
                                                                                <option value="{{ $alat->id }}" {{ $formPemakaianAlat->alat_id == $alat->id ? 'selected' : '' }}>{{ $alat->nama_barang }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="ukuran[]" class="form-label">Ukuran</label>
                                                                        <input type="text" class="form-control" name="ukuran[]" value="{{ $formPemakaianAlat->ukuran }}" required>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label for="kondisi_pinjam[]" class="form-label">Kondisi Pinjam</label>
                                                                        <select class="form-control" name="kondisi_pinjam[]">
                                                                            <option value="Baik" {{ $formPemakaianAlat->kondisi_pinjam == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                                            <option value="Pecah" {{ $formPemakaianAlat->kondisi_pinjam == 'Pecah' ? 'selected' : '' }}>Pecah</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for="jumlah[]" class="form-label">Jumlah Pinjam</label>
                                                                        <input type="number" class="form-control" name="jumlah[]" value="{{ $formPemakaianAlat->jumlah }}" required>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-2">
                                                                        <label for="kondisi_kembali[]" class="form-label">Kondisi Kembali</label>
                                                                        <select class="form-control" name="kondisi_kembali[]">
                                                                            <option value="Baik" {{ $formPemakaianAlat->kondisi_kembali == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                                            <option value="Pecah" {{ $formPemakaianAlat->kondisi_kembali == 'Pecah' ? 'selected' : '' }}>Pecah</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for="jumlah_rusak[]" class="form-label">Jumlah Rusak</label>
                                                                        <input type="number" class="form-control" name="jumlah_rusak[]" value="{{ $formPemakaianAlat->jumlah_rusak }}" required>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="keterangan[]" class="form-label">Keterangan</label>
                                                                        <input type="text" class="form-control" name="keterangan[]" value="{{ $formPemakaianAlat->keterangan }}">
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>  

                                        <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('pemakaian-alat.updateDetail', $pemakaianAlat->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Tambah Data Pemakaian Alat</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" value="{{ $pemakaianAlat->id }}">

                                                            <div class="mb-3">
                                                                <label for="nama_barang" class="form-label">Nama Alat<span style="color: red;">*</span></label>
                                                                <select class="form-control" name="nama_barang" required>
                                                                        <option value="">-- Pilih Alat --</option>
                                                                        @foreach($alats as $alat)
                                                                            <option value="{{ $alat->id }}">{{ $alat->nama_barang }}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                        
                                                            <div class="mb-3">
                                                                <label for="ukuran" class="form-label">Ukuran<span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" name="ukuran" required>
                                                            </div>
                                        
                                                            <div class="mb-3">
                                                                <label for="kondisi_pinjam" class="form-label">Kondisi Pinjam<span style="color: red;">*</span></label>
                                                                <select class="form-control" name="kondisi_pinjam" required>
                                                                    <option value="">--Pilih--</option>
                                                                    <option value="Baik">Baik</option>
                                                                    <option value="Pecah">Pecah</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="jumlah" class="form-label">Jumlah Pinjam<span style="color: red;">*</span></label>
                                                                <input type="number" class="form-control" name="jumlah" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="kondisi_kembali" class="form-label">Kondisi Kembali<span style="color: red;">*</span></label>
                                                                <select class="form-control" name="kondisi_kembali" required>
                                                                    <option value="">--Pilih--</option>
                                                                    <option value="Baik">Baik</option>
                                                                    <option value="Pecah">Pecah</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="jumlah_rusak" class="form-label">Jumlah Rusak<span style="color: red;">*</span></label>
                                                                <input type="number" class="form-control" name="jumlah_rusak" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                                <input type="text" class="form-control" name="keterangan">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        @if ($pemakaianAlat->status != 0)
                                            <div class="alert alert-primary mt-3" role="alert">
                                                Data yang sudah di ACC tidak bisa diedit atau dihapus!
                                            </div>
                                        @endif

                                        <hr>

                                        <h3>Pemakaian Alat</h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nama Barang</th>
                                                    <th>Ukuran</th>
                                                    <th>Kondisi Pinjam</th>
                                                    <th>Jumlah Pinjam</th>
                                                    <th>Kondisi Kembali</th>
                                                    <th>Jumlah Pecah</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pemakaianAlat->formPemakaianAlats as $formPemakaianAlat)
                                                    <tr>
                                                        <td>
                                                            @if ($formPemakaianAlat->alat)
                                                                <a style="color: black" href="{{ route('data-alat.show', $formPemakaianAlat->alat->id ) }}">{{ $formPemakaianAlat->alat->nama_barang ?? 'N/A' }}</a>
                                                            @else
                                                                {{ $formPemakaianAlat->alat->nama_barang ?? 'N/A' }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $formPemakaianAlat->ukuran ?? 'N/A' }}</td>
                                                        <td>{{ $formPemakaianAlat->kondisi_pinjam }}</td>
                                                        <td>{{ $formPemakaianAlat->jumlah ?? 'N/A' }}</td>
                                                        <td>{{ $formPemakaianAlat->kondisi_kembali }}</td>
                                                        <td>{{ $formPemakaianAlat->jumlah_rusak }}</td>
                                                        <td>{{ $formPemakaianAlat->keterangan }}</td>
                                                        <td>
                                                            @if ($pemakaianAlat->status == 0)
                                                                <form action="{{ route('destroyPengajuanPeminjamanAlat', $formPemakaianAlat->id) }}"
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
    @endpush
@endsection