@extends('layouts.app')

@section('title')
    Data Obat Keluar
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
                                <h4 class="mb-sm-0">Data Obat Keluar ({{ $obat_keluars->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Obat</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Obat Masuk</a></li>
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
                            <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-plus"></i> Tambah Data Bahan Keluar
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Obat Keluar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('data-obat-keluar.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="obat_id" class="form-label">Nama Obat <span style="color: red">*</span> </label>
                                                    <select class="form-control @error('obat_id') is-invalid @enderror" id="obat_id" name="obat_id" required>
                                                        <option value="">-- Pilih --</option>
                                                        @foreach($obats as $obat)
                                                            <option value="{{ $obat->id }}">{{ $obat->kode_obat }} - {{ $obat->nama_obat }}</option>
                                                        @endforeach
                                                    </select>
                                            
                                                    @error('obat_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="stok_obat" class="form-label">Stok <span style="color: red">*</span> </label>
                                                    <input type="text" class="form-control @error('stok_obat') is-invalid @enderror" id="stok_obat" name="stok_obat" readonly required>
                                            
                                                    @error('stok_obat')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="jumlah_pemakaian" class="form-label">Jumlah Pemakaian <span style="color: red">*</span> </label>
                                                    <input type="number" class="form-control @error('jumlah_pemakaian') is-invalid @enderror" id="jumlah_pemakaian" name="jumlah_pemakaian" required>
                                            
                                                    @error('jumlah_pemakaian')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <!-- Warning message for exceeding stock -->
                                                <div id="warning-message" style="display:none; color: red; font-weight: bold;">
                                                    Jumlah pemakaian melebihi stok yang tersedia!
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="tanggal_keluar" class="form-label">Tanggal <span style="color: red">*</span> </label>
                                                    <input type="date"
                                                        class="form-control @error('tanggal_keluar') is-invalid @enderror" id="tanggal_keluar"
                                                        name="tanggal_keluar" required>
                                            
                                                    @error('tanggal_keluar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan <span style="color: red">*</span> </label>
                                                    <input type="text"
                                                        class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                                        name="keterangan" required>
                                            
                                                    @error('keterangan')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
        
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Kode - Nama Obat</th>
                                                <th>Jumlah Pemakaian</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($obat_keluars as $key => $obat_keluar)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>
                                                            <span id="tanggal-text-{{ $obat_keluar->id }}">
                                                                {{ $obat_keluar->tanggal_keluar ? \Carbon\Carbon::parse($obat_keluar->tanggal_keluar)->format('d-m-Y') : '-' }}
                                                            </span>
                                                            <i class="fas fa-edit" style="cursor: pointer;" onclick="editTanggal({{ $obat_keluar->id }})"></i>
                                                            
                                                            <form id="edit-form-{{ $obat_keluar->id }}" class="d-none">
                                                                <input type="date" id="tanggal-input-{{ $obat_keluar->id }}" value="{{ $obat_keluar->tanggal_keluar }}" class="form-control d-inline w-auto" />
                                                                <button type="button" onclick="saveTanggal({{ $obat_keluar->id }})" class="btn btn-sm btn-success">Simpan</button>
                                                                <button type="button" onclick="cancelEdit({{ $obat_keluar->id }})" class="btn btn-sm btn-secondary">Batal</button>
                                                            </form>
                                                        </td>
                                                        <td><a style="color: black" href="{{ route('data-obat.show', $obat_keluar->obat->id) }}">{{ $obat_keluar->obat->kode_obat }} - {{ $obat_keluar->obat->nama_obat }}</a></td>
                                                        <td>{{ $obat_keluar->jumlah_pemakaian }}</td>
                                                        <td>
                                                            <a href="{{ route('data-obat.show', $obat_keluar->obat->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>
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
            // Mengambil stok bahan saat memilih bahan
            document.getElementById('obat_id').addEventListener('change', function() {
                var obatId = this.value;
        
                if (obatId) {
                    fetch(`/get-stok/${obatId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.stok_obat !== undefined) {
                                document.getElementById('stok_obat').value = data.stok_obat;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        
            // Menampilkan pesan jika jumlah pemakaian melebihi stok
            document.getElementById('jumlah_pemakaian').addEventListener('input', function() {
                var jumlahPemakaian = parseInt(this.value, 10);
                var stokObat = parseInt(document.getElementById('stok_obat').value, 10);
        
                var warningMessage = document.getElementById('warning-message');
        
                // Jika jumlah pemakaian lebih besar dari stok bahan
                if (jumlahPemakaian > stokObat) {
                    // Tampilkan pesan peringatan
                    warningMessage.style.display = 'block';
                } else {
                    // Sembunyikan pesan peringatan jika tidak lebih dari stok
                    warningMessage.style.display = 'none';
                }
            });
        </script>

        <script>
            function editTanggal(id) {
                // Sembunyikan teks tanggal dan tampilkan form edit
                document.getElementById(`tanggal-text-${id}`).style.display = 'none';
                document.getElementById(`edit-form-${id}`).classList.remove('d-none');
            }

            function cancelEdit(id) {
                // Tampilkan teks tanggal dan sembunyikan form edit
                document.getElementById(`edit-form-${id}`).classList.add('d-none');
                document.getElementById(`tanggal-text-${id}`).style.display = 'inline';
            }

            function saveTanggal(id) {
                const tanggalKeluar = document.getElementById(`tanggal-input-${id}`).value;

                fetch(`/stok-keluar/${id}/update-tanggal`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ tanggal_keluar: tanggalKeluar })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Format tanggal ke d-m-Y
                        const [year, month, day] = tanggalKeluar.split('-');
                        const formattedDate = `${day}-${month}-${year}`;

                        // Perbarui teks tanggal
                        document.getElementById(`tanggal-text-${id}`).textContent = formattedDate;

                        // Sembunyikan form dan tampilkan teks
                        cancelEdit(id);
                        alert(data.message);
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    console.error(error);
                });
            }

        </script>

    @endpush
@endsection