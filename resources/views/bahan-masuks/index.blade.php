@extends('layouts.app')

@section('title')
    Data Bahan Masuk
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
                                <h4 class="mb-sm-0">Data Bahan Masuk ({{ $bahan_masuks->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bahan</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Bahan Masuk</a></li>
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

                            <div class="d-flex">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
                                    <i class="fas fa-plus"></i> Import Data Bahan Masuk
                                </button>

                                <button type="button" class="btn btn-primary btn-sm mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="fas fa-plus"></i> Tambah Data Bahan Masuk Manual
                                </button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importModalLabel">Import Data Bahan Masuk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('data-bahan-masuk.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">

                                                <div class="alert alert-primary" role="alert">
                                                    Sebelum melanjutkan, pastikan data excel anda sudah sesuai dengan template yang ditentukan, jika belum silahkan download template excel <a href="{{ asset('template-excel/template-bahan-masuk.xls') }}">disini</a>
                                                </div>

                                                <div class="mb-3">

                                                    <div class="mb-3">
                                                        <label for="file" class="form-label">Pilih File Excel <span style="color: red">*</span> </label>
                                                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
        
                                                        @error('file')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="foto_path" class="form-label">Foto Bukti Transaski (bisa lebih dari 1 foto) <span style="color: red">*</span> </label>
                                                        <input type="file"
                                                            class="form-control @error('foto_path') is-invalid @enderror" id="foto_path"
                                                            name="foto_path">
        
                                                        @error('foto_path')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Import</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Bahan Masuk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('data-bahan-manual.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="bahan_id" class="form-label">Nama Bahan<span style="color: red">*</span> </label>
                                                    <select class="form-control @error('bahan_id') is-invalid @enderror" id="bahan_id" name="bahan_id" required>
                                                        <option value="">-- Pilih --</option>
                                                        @foreach($bahans as $bahan)
                                                        <option value="{{ $bahan->id }}">{{ $bahan->kode_bahan }} - {{ $bahan->nama_bahan }} ({{ $bahan->formula }}) - {{ $bahan->jenis_bahan }}</option>
                                                        @endforeach
                                                    </select>
                                                
                                                    @error('bahan_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="jumlah_masuk" class="form-label">Jumlah Masuk<span style="color: red">*</span> </label>
                                                    <input type="number"
                                                        class="form-control @error('jumlah_masuk') is-invalid @enderror" id="jumlah_masuk"
                                                        name="jumlah_masuk" value="{{ old('jumlah_masuk') }}" required>

                                                    @error('jumlah_masuk')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk<span style="color: red">*</span></label>
                                                    <input type="date"
                                                        class="form-control @error('tanggal_masuk') is-invalid @enderror" id="tanggal_masuk"
                                                        name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required>

                                                    @error('tanggal_masuk')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="exp_bahan" class="form-label">Expired Bahan</label>
                                                    <input type="date"
                                                        class="form-control @error('exp_bahan') is-invalid @enderror" id="exp_bahan"
                                                        name="exp_bahan" value="{{ old('exp_bahan') }}">

                                                    @error('exp_bahan')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                                    <input type="number"
                                                        class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan"
                                                        name="harga_satuan">

                                                    @error('harga_satuan')
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

                                            <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#bahanPadat" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-tint"></i></span>
                                                <span class="d-none d-sm-block">Bahan Padat</span> 
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#bahanCair" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-window-maximize"></i></span>
                                                    <span class="d-none d-sm-block">Bahan Cair</span> 
                                            </a>
                                        </li>
                                    </ul>
    
                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="bahanPadat" role="tabpanel">

                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal Masuk</th>
                                                        <th>Kode - Nama Bahan</th>
                                                        <th>Jenis Bahan</th>
                                                        <th>Jumlah Masuk</th>
                                                        <th>Harga Satuan</th>
                                                        <th>Total Harga</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    @php $counter = 1; @endphp
                                                    @foreach($bahan_masuks as $bahan_masuk)
        
                                                        @if($bahan_masuk->bahan->jenis_bahan == 'Padat')
                                                            <tr>
                                                                <th scope="row">{{ $counter++ }}</th>
                                                                <td>
                                                                    <!-- Teks tanggal dan ikon edit -->
                                                                    <span id="tanggal-text-{{ $bahan_masuk->id }}">
                                                                        {{ $bahan_masuk->tanggal_masuk ? \Carbon\Carbon::parse($bahan_masuk->tanggal_masuk)->format('d-m-Y') : '-' }}
                                                                    </span>
                                                                    <i class="fas fa-edit" style="cursor: pointer;" onclick="editTanggal({{ $bahan_masuk->id }})"></i>
                                                                    
                                                                    <!-- Form edit -->
                                                                    <form id="edit-form-{{ $bahan_masuk->id }}" class="d-none">
                                                                        <input type="date" id="tanggal-input-{{ $bahan_masuk->id }}" value="{{ $bahan_masuk->tanggal_masuk }}" class="form-control d-inline w-auto" />
                                                                        <button type="button" onclick="saveTanggal({{ $bahan_masuk->id }})" class="btn btn-sm btn-success">Simpan</button>
                                                                        <button type="button" onclick="cancelEdit({{ $bahan_masuk->id }})" class="btn btn-sm btn-secondary">Batal</button>
                                                                    </form>
                                                                </td>                                                                
                                                                <td><a style="color: black" href="{{ route('data-bahan.show', $bahan_masuk->bahan->id) }}">{{ $bahan_masuk->bahan->kode_bahan }} - {{ $bahan_masuk->bahan->nama_bahan }}</a></td>
                                                                <td>{{ $bahan_masuk->bahan->jenis_bahan }}</td>
                                                                <td>{{ $bahan_masuk->jumlah_masuk }}</td>
                                                                <td>Rp. {{ number_format((float) $bahan_masuk->harga_satuan) }}</td>
                                                                <td>Rp. {{ number_format((float) $bahan_masuk->total_harga) }}</td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <a href="{{ route('data-bahan.show', $bahan_masuk->bahan->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>

                                                                        <form id="input"
                                                                            action="{{ route('data-bahan-masuk.destroy', $bahan_masuk->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus data bahan masuk ini?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                        </form>

                                                                        @if ($bahan_masuk->fotoBahanMasuks->count() > 0)
                                                                            @foreach ($bahan_masuk->fotoBahanMasuks as $foto)
                                                                                <a href="{{ asset($foto->foto_path) }}" class="btn btn-info btn-sm" target="_blank" title="Lihat Bukti Transaksi"> <i class="fas fa-file-invoice-dollar"></i> </a>
                                                                                <br>
                                                                            @endforeach
                                                                        @else
                                                                            <span>-</span>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                            
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                        <div class="tab-pane" id="bahanCair" role="tabpanel">

                                            <table id="datatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal Masuk</th>
                                                        <th>Kode - Nama Bahan</th>
                                                        <th>Jenis Bahan</th>
                                                        <th>Jumlah Masuk</th>
                                                        <th>Harga Satuan</th>
                                                        <th>Total Harga</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    @php $counter2 = 1; @endphp
                                                    @foreach($bahan_masuks as $bahan_masuk)
        
                                                        @if($bahan_masuk->bahan->jenis_bahan != 'Padat')
                                                            <tr>
                                                                <th scope="row">{{ $counter2++ }}</th>
                                                                <td>
                                                                    <!-- Teks tanggal dan ikon edit -->
                                                                    <span id="tanggal-text-{{ $bahan_masuk->id }}">
                                                                        {{ $bahan_masuk->tanggal_masuk ? \Carbon\Carbon::parse($bahan_masuk->tanggal_masuk)->format('d-m-Y') : '-' }}
                                                                    </span>
                                                                    <i class="fas fa-edit" style="cursor: pointer;" onclick="editTanggal({{ $bahan_masuk->id }})"></i>
                                                                    
                                                                    <!-- Form edit -->
                                                                    <form id="edit-form-{{ $bahan_masuk->id }}" class="d-none">
                                                                        <input type="date" id="tanggal-input-{{ $bahan_masuk->id }}" value="{{ $bahan_masuk->tanggal_masuk }}" class="form-control d-inline w-auto" />
                                                                        <button type="button" onclick="saveTanggal({{ $bahan_masuk->id }})" class="btn btn-sm btn-success">Simpan</button>
                                                                        <button type="button" onclick="cancelEdit({{ $bahan_masuk->id }})" class="btn btn-sm btn-secondary">Batal</button>
                                                                    </form>
                                                                </td>                                                                
                                                                <td><a style="color: black" href="{{ route('data-bahan.show', $bahan_masuk->bahan->id) }}">{{ $bahan_masuk->bahan->kode_bahan }} - {{ $bahan_masuk->bahan->nama_bahan }}</a></td>
                                                                <td>{{ $bahan_masuk->bahan->jenis_bahan }}</td>
                                                                <td>{{ $bahan_masuk->jumlah_masuk }}</td>
                                                                <td>Rp. {{ number_format((float) $bahan_masuk->harga_satuan) }}</td>
                                                                <td>Rp. {{ number_format((float) $bahan_masuk->total_harga) }}</td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <a href="{{ route('data-bahan.show', $bahan_masuk->bahan->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>

                                                                        <form id="input"
                                                                                action="{{ route('data-bahan-masuk.destroy', $bahan_masuk->id) }}"
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus data bahan masuk ini?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger btn-sm mx-1" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                                                            </form>

                                                                        @if ($bahan_masuk->fotoBahanMasuks->count() > 0)
                                                                            @foreach ($bahan_masuk->fotoBahanMasuks as $foto)
                                                                                <a href="{{ asset($foto->foto_path) }}" class="btn btn-info btn-sm" target="_blank" title="Lihat Bukti Transaksi"> <i class="fas fa-file-invoice-dollar"></i> </a>
                                                                                <br>
                                                                            @endforeach
                                                                        @else
                                                                            <span>-</span>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                            
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>

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
            const tanggalMasuk = document.getElementById(`tanggal-input-${id}`).value;

            fetch(`/bahan-masuk/${id}/update-tanggal`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ tanggal_masuk: tanggalMasuk })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Format tanggal ke d-m-Y
                    const [year, month, day] = tanggalMasuk.split('-');
                    const formattedDate = `${day}-${month}-${year}`;

                    // Perbarui teks tanggal dengan format d-m-Y
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