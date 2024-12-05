@extends('layouts.app')

@section('title')
    Data Semester
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
                                <h4 class="mb-sm-0">Data Semester</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Semester</a></li>
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
                            <button type="button" class="btn btn-success btn-sm mb-3 mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-plus"></i> Tambah Data Semester
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Semester</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('semesters.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="semester" class="form-label">Semester <span style="color: red">*</span> </label>
                                                    <input type="text"
                                                        class="form-control @error('semester') is-invalid @enderror" id="semester"
                                                        name="semester" value="{{ old('semester') }}" placeholder="contoh: Ganjil" required>

                                                    @error('semester')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>
                                                <div class="mb-3">
                                                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span style="color: red">*</span> </label>
                                                    <input type="text"
                                                        class="form-control @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran"
                                                        name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" placeholder="contoh: 2024/2025" required>

                                                    @error('tahun_ajaran')
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
                                                <th>Semester</th>
                                                <th>Tahun Ajaran</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                                @foreach($semesters as $key => $semester)

                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>{{ $semester->semester }}</td>
                                                        <td>{{ $semester->tahun_ajaran }}</td>
                                                        <td>{{ $semester->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                                        <td>
                                                            @if(!$semester->is_active)
                                                                <form action="{{ route('semesters.activate', $semester->id) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success btn-sm" title="Aktifkan"><i class="fas fa-check"></i></button>
                                                                </form>
                                                            @endif
                                                            @if($semester->is_active)
                                                                <form action="{{ route('semesters.deactivate', $semester->id) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-warning btn-sm" title="Nonaktifkan"><i class="fas fa-times"></i></button>
                                                                </form>
                                                            @endif
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

    @endpush
@endsection