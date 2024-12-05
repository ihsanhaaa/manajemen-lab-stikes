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

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-plus"></i> Import Data Bahan Masuk
                            </button>

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
                                                        <th>Nama Bahan</th>
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
                                                                <td>{{ $bahan_masuk->tanggal_masuk }}</td>
                                                                <td>{{ $bahan_masuk->bahan->nama_bahan }}</td>
                                                                <td>{{ $bahan_masuk->bahan->jenis_bahan }}</td>
                                                                <td>{{ $bahan_masuk->jumlah_masuk }}</td>
                                                                <td>Rp. {{ number_format((float) $bahan_masuk->harga_satuan) }}</td>
                                                                <td>Rp. {{ number_format((float) $bahan_masuk->total_harga) }}</td>
                                                                <td>
                                                                    <a href="{{ route('data-bahan.show', $bahan_masuk->bahan->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>

                                                                    @if ($bahan_masuk->fotoBahanMasuks->count() > 0)
                                                                        @foreach ($bahan_masuk->fotoBahanMasuks as $foto)
                                                                            <a href="{{ asset($foto->foto_path) }}" class="btn btn-info btn-sm" target="_blank" title="Lihat Bukti Transaksi"> <i class="fas fa-file-invoice-dollar"></i> </a>
                                                                            <br>
                                                                        @endforeach
                                                                    @else
                                                                        <span>-</span>
                                                                    @endif
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
                                                        <th>Nama Bahan</th>
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
        
                                                        @if($bahan_masuk->bahan->jenis_bahan == 'Cairan')
                                                            <tr>
                                                                <th scope="row">{{ $counter2++ }}</th>
                                                                <td>{{ $bahan_masuk->tanggal_masuk }}</td>
                                                                <td>{{ $bahan_masuk->bahan->nama_bahan }}</td>
                                                                <td>{{ $bahan_masuk->bahan->jenis_bahan }}</td>
                                                                <td>{{ $bahan_masuk->jumlah_masuk }}</td>
                                                                <td>Rp. {{ number_format((float) $bahan_masuk->harga_satuan) }}</td>
                                                                <td>Rp. {{ number_format((float) $bahan_masuk->total_harga) }}</td>
                                                                <td>
                                                                    <a href="{{ route('data-bahan.show', $bahan_masuk->bahan->id) }}" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i> </a>

                                                                    @if ($bahan_masuk->fotoBahanMasuks->count() > 0)
                                                                        @foreach ($bahan_masuk->fotoBahanMasuks as $foto)
                                                                            <a href="{{ asset($foto->foto_path) }}" class="btn btn-info btn-sm" target="_blank" title="Lihat Bukti Transaksi"> <i class="fas fa-file-invoice-dollar"></i> </a>
                                                                            <br>
                                                                        @endforeach
                                                                    @else
                                                                        <span>-</span>
                                                                    @endif
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

    @endpush
@endsection