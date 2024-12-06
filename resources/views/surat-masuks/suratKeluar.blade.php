@extends('layouts.app')

@section('title')
    Data Surat Keluar
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
                                <h4 class="mb-sm-0">Data Surat Keluar ({{ $surat_keluars->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Surat</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Surat Keluar</a></li>
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

                            {{-- tombol --}}

                            <div class="card">
                                <div class="card-body">
        
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Perihal</th>
                                                <th>Nomor Surat</th>
                                                <th>Kategori</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                                @foreach($surat_keluars as $key => $surat_keluar)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>{{ $surat_keluar->nama_berkas }}</td>
                                                        <td>{{ $surat_keluar->nomor_berkas }}</td>
                                                        <td>{{ $surat_keluar->kategori_berkas }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal{{ $surat_keluar->id }}" title="Lihat Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                    
                                                            <!-- Modal Detail -->
                                                            <div class="modal fade" id="showModal{{ $surat_keluar->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $surat_keluar->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="showModalLabel{{ $surat_keluar->id }}">Detail Surat</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Tampilan Detail -->
                                                                            <div id="detail-view-{{ $surat_keluar->id }}">
                                                                                <div class="d-flex">
                                                                                    <div class="flex-grow-1">
                                                                                        <h4 class="mb-3">{{ $surat_keluar->nama_berkas }}</h4>
                                                                                        <p class="text-muted mb-2 nomor-surat">
                                                                                            <i class="fas fa-copy"></i> Nomor Surat: {{ $surat_keluar->nomor_berkas }}
                                                                                        </p>
                                                                                        @if ($surat_keluar->kategori_berkas == 'Surat MOU')
                                                                                            <p class="text-muted mb-2 tanggal-mulai">
                                                                                                <i class="far fa-calendar-check"></i> Tanggal Mulai: {{ $surat_keluar->tanggal_mulai }}
                                                                                            </p>
                                                                                            <p class="text-muted mb-2 tanggal-berakhir">
                                                                                                <i class="far fa-calendar-times"></i> Tanggal Berakhir: {{ $surat_keluar->tanggal_berakhir }}
                                                                                            </p>
                                                                                        @endif
                                                                                        <p class="text-muted mb-2 tanggal-surat">
                                                                                            <i class="far fa-calendar"></i> Tanggal Surat: {{ $surat_keluar->tanggal_berkas }}
                                                                                        </p>
                                                                                        
                                                                                        <p class="text-muted mb-2"> <i class="fas fa-clock"></i> Dibuat Pada: {{ $surat_keluar->created_at }}</p>
                                                                                    </div>
                                                                                    <div class="avatar-sm">
                                                                                        @foreach ($surat_keluar->fileSurats as $fileSurat)
                                                                                            <span class="avatar-title bg-light text-primary rounded-3 my-1">
                                                                                                <a href="{{ asset($fileSurat->file_path) }}" target="_blank" title="Lihat atau Download File">
                                                                                                    <i class="ri-file-2-line font-size-24"></i>
                                                                                                </a>
                                                                                            </span>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Tampilan Form Edit (disembunyikan default) -->
                                                                            <div id="edit-view-{{ $surat_keluar->id }}" style="display: none;">
                                                                                <form id="formEditSurat{{ $surat_keluar->id }}">
                                                                                    @csrf
                                                                                    <input type="hidden" name="id" value="{{ $surat_keluar->id }}">
                                                                                    <div class="mb-3">
                                                                                        <label for="nama_berkas_{{ $surat_keluar->id }}" class="form-label">Nama Berkas</label>
                                                                                        <input type="text" class="form-control" id="nama_berkas_{{ $surat_keluar->id }}" name="nama_berkas" value="{{ $surat_keluar->nama_berkas }}">
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label for="nomor_berkas_{{ $surat_keluar->id }}" class="form-label">Nomor Surat</label>
                                                                                        <input type="text" class="form-control" id="nomor_berkas_{{ $surat_keluar->id }}" name="nomor_berkas" value="{{ $surat_keluar->nomor_berkas }}">
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label for="tanggal_berkas_{{ $surat_keluar->id }}" class="form-label">Tanggal Surat</label>
                                                                                        <input type="date" class="form-control" id="tanggal_berkas_{{ $surat_keluar->id }}" name="tanggal_berkas" value="{{ $surat_keluar->tanggal_berkas }}">
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <!-- Tombol untuk Edit -->
                                                                            <button type="button" class="btn btn-warning" id="editBtn{{ $surat_keluar->id }}" onclick="toggleEdit('{{ $surat_keluar->id }}')">Edit</button>

                                                                            <!-- Tombol untuk Simpan -->
                                                                            <button type="button" class="btn btn-primary" id="saveBtn{{ $surat_keluar->id }}" style="display: none;" onclick="saveChanges('{{ $surat_keluar->id }}')">Simpan</button>

                                                                            <!-- Tombol untuk Tutup -->
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @foreach ($surat_keluar->fileSurats as $fileSurat)
                                                                <a href="{{ asset($fileSurat->file_path) }}" target="_blank" class="btn btn-info btn-sm mx-1" title="Lihat File Surat"><i class="fas fa-file-alt"></i> </a>
                                                            @endforeach

                                                            <div class="btn-group me-2 mb-2 mb-sm-0">
                                                                <button type="button" class="btn btn-primary btn-sm waves-light waves-effect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fas fa-edit"></i> <i class="mdi mdi-dots-vertical ms-2"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeCategory('{{ $surat_keluar->id }}', 'Surat Masuk')">Pindahkan ke Surat Masuk</a>
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeCategory('{{ $surat_keluar->id }}', 'Surat Penting')">Pindahkan ke Surat Penting</a>
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeCategory('{{ $surat_keluar->id }}', 'Surat SK')">Pindahkan ke Surat SK</a>
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeCategory('{{ $surat_keluar->id }}', 'Surat Arsip')">Pindahkan ke Surat Arsip</a>
                                                                </div>
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
            function toggleEdit(id) {
                // Sembunyikan detail view, tampilkan edit view
                $(`#detail-view-${id}`).hide();
                $(`#edit-view-${id}`).show();

                // Sembunyikan tombol Edit, tampilkan tombol Simpan
                $(`#editBtn${id}`).hide();
                $(`#saveBtn${id}`).show();
            }

            function saveChanges(id) {
                // Ambil data dari form
                let formData = $(`#formEditSurat${id}`).serialize();

                // Kirim data dengan AJAX
                $.ajax({
                    url: `/surat-masuk/update/${id}`, // Ganti dengan endpoint Laravel Anda
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Tampilkan pesan sukses
                        alert('Data berhasil diperbarui!');

                        // Perbarui tampilan detail view dengan data terbaru
                        $(`#detail-view-${id} h4`).text(response.data.nama_berkas);
                        $(`#detail-view-${id} .nomor-surat`).text(response.data.nomor_berkas);
                        $(`#detail-view-${id} .tanggal-surat`).text(response.data.tanggal_berkas);

                        // Tampilkan kembali detail view, sembunyikan form edit
                        $(`#edit-view-${id}`).hide();
                        $(`#detail-view-${id}`).show();

                        // Tampilkan tombol Edit, sembunyikan tombol Simpan
                        $(`#editBtn${id}`).show();
                        $(`#saveBtn${id}`).hide();
                    },
                    error: function(error) {
                        alert('Terjadi kesalahan saat menyimpan data!');
                    }
                });
            }

        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const kategoriBerkas = document.getElementById('kategori_berkas');
                const tanggalRange = document.getElementById('tanggal-range');

                // Event listener untuk dropdown
                kategoriBerkas.addEventListener('change', function () {
                    if (kategoriBerkas.value === 'Surat MOU') {
                        tanggalRange.style.display = 'block'; // Tampilkan form tanggal
                    } else {
                        tanggalRange.style.display = 'none'; // Sembunyikan form tanggal
                    }
                });
            });
        </script>

        <script>
            function changeCategory(id, newCategory) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Kategori surat akan diubah menjadi ${newCategory}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, ubah!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim data ke server
                        fetch(`/surats/update-kategori/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ kategori_berkas: newCategory })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Berhasil!', data.success, 'success').then(() => {
                                    location.reload(); // Reload halaman
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                        });
                    }
                });
            }
        </script>

    @endpush
@endsection