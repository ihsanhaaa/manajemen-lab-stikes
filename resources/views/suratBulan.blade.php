@extends('layouts.app')

@section('title')
    Data Surat per Bulan
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
                                <h4 class="mb-sm-0">Data Surat Bulan {{ $bulan }} ({{ $surat->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Surat Bulan {{ $bulan }} </a></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

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
        
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kategori</th>
                                                <th>Perihal</th>
                                                <th>Nomor Surat</th>
                                                <th>Tanggal Surat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($surat as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->kategori_berkas }}</td>
                                                    <td>{{ $item->nama_berkas }}</td>
                                                    <td>{{ $item->nomor_berkas }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_berkas)->format('d-m-Y') }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal{{ $item->id }}" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                
                                                        <!-- Modal Detail -->
                                                        <div class="modal fade" id="showModal{{ $item->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $item->id }}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="showModalLabel{{ $item->id }}">Detail Surat</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Tampilan Detail -->
                                                                        <div id="detail-view-{{ $item->id }}">
                                                                            <div class="d-flex">
                                                                                <div class="flex-grow-1">
                                                                                    <h4 class="mb-3">{{ $item->nama_berkas }}</h4>
                                                                                    <p class="text-muted mb-2 nomor-surat">
                                                                                        <i class="fas fa-copy"></i> Nomor Surat: {{ $item->nomor_berkas }}
                                                                                    </p>
                                                                                    @if ($item->kategori_berkas == 'Surat MOU')
                                                                                        <p class="text-muted mb-2 tanggal-mulai">
                                                                                            <i class="far fa-calendar-check"></i> Tanggal Mulai: {{ $item->tanggal_mulai }}
                                                                                        </p>
                                                                                        <p class="text-muted mb-2 tanggal-berakhir">
                                                                                            <i class="far fa-calendar-times"></i> Tanggal Berakhir: {{ $item->tanggal_berakhir }}
                                                                                        </p>
                                                                                    @endif
                                                                                    <p class="text-muted mb-2 tanggal-surat">
                                                                                        <i class="far fa-calendar"></i> Tanggal Surat: {{ $item->tanggal_berkas }}
                                                                                    </p>
                                                                                    
                                                                                    <p class="text-muted mb-2"> <i class="fas fa-clock"></i> Dibuat Pada: {{ $item->created_at }}</p>
                                                                                </div>
                                                                                <div class="avatar-sm">
                                                                                    @foreach ($item->fileSurats as $fileSurat)
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
                                                                        <div id="edit-view-{{ $item->id }}" style="display: none;">
                                                                            <form id="formEditSurat{{ $item->id }}">
                                                                                @csrf
                                                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                                                <div class="mb-3">
                                                                                    <label for="nama_berkas_{{ $item->id }}" class="form-label">Nama Berkas</label>
                                                                                    <input type="text" class="form-control" id="nama_berkas_{{ $item->id }}" name="nama_berkas" value="{{ $item->nama_berkas }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="nomor_berkas_{{ $item->id }}" class="form-label">Nomor Surat</label>
                                                                                    <input type="text" class="form-control" id="nomor_berkas_{{ $item->id }}" name="nomor_berkas" value="{{ $item->nomor_berkas }}">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="tanggal_berkas_{{ $item->id }}" class="form-label">Tanggal Surat</label>
                                                                                    <input type="date" class="form-control" id="tanggal_berkas_{{ $item->id }}" name="tanggal_berkas" value="{{ $item->tanggal_berkas }}">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <!-- Tombol untuk Edit -->
                                                                        <button type="button" class="btn btn-warning" id="editBtn{{ $item->id }}" onclick="toggleEdit('{{ $item->id }}')">Edit</button>

                                                                        <!-- Tombol untuk Simpan -->
                                                                        <button type="button" class="btn btn-primary" id="saveBtn{{ $item->id }}" style="display: none;" onclick="saveChanges('{{ $item->id }}')">Simpan</button>

                                                                        <!-- Tombol untuk Tutup -->
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </div>
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
    @endpush
@endsection