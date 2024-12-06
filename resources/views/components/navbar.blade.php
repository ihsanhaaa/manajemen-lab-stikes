<div class="st-height-70"></div>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('/') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('STIKES.png') }}" alt="logo-sm" height="47">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('STIKES.png') }}" alt="logo-dark" height="45">
                    </span>
                </a>

                <a href="{{ url('/') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('STIKES.png') }}" alt="logo-sm-light" height="47">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('STIKES.png') }}" alt="logo-light" height="45">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="https://api.dicebear.com/5.x/identicon/svg?seed={{ Auth::user()->name }}"
                        alt="Header Avatar">
                    @guest
                        <span class="d-none d-xl-inline-block ms-1"></span>
                    @else
                        <span class="d-none d-xl-inline-block ms-1">Hai, {{ Auth::user()->name }}</span>
                    @endguest
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    @guest
                        <a class="dropdown-item" href="{{ url('/') }}"><i class="ri-home-line align-middle me-1"></i> Dashboard</a>
                        <li><a class="dropdown-item" href="{{ route('login') }}">Masuk</a></li>
                    @else
                        <a class="dropdown-item" href="{{ route('home') }}"><i class="ri-home-line align-middle me-1"></i> Dashboard</a>
                                
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <span style="color:red;"> <i class="ri-logout-circle-r-line me-1"></i> Keluar</span> </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        </form>
                    @endguest
                </div>
            </div>

        </div>
    </div>
</header>
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                @guest
                    <li>
                        <a href="{{ url('/') }}" class="waves-effect">
                            <i class="ri-dashboard-line">
                            <span>Beranda</span>
                        </a>
                    </li>
                @else
                    @role('Ketua STIKes')
                        <li>
                            <a href="{{ route('home') }}" class="waves-effect">
                                <i class="ri-home-line"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('semesters.index') }}" class="waves-effect">
                                <i class="ri-book-mark-line"></i>
                                <span>Manajemen Semester</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-article-line"></i>
                                <span>Surat</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('data-surat-masuk.index') }}">Surat Masuk</a></li>
                                <li><a href="{{ route('data-surat-keluar.index') }}">Surat Keluar</a></li>
                                <li><a href="{{ route('data-surat-penting.index') }}">Surat Penting</a></li>
                                <li><a href="{{ route('data-surat-sk.index') }}">Surat SK</a></li>
                                <li><a href="{{ route('data-surat-arsip.index') }}">Surat Arsip</a></li>
                                <li><a href="{{ route('data-surat-mou.index') }}">Surat MOU</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-contrast-fill"></i>
                                <span>Obat</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('data-kemasan.index') }}">Data Kemasan</a></li>
                                <li><a href="{{ route('data-bentuk-sediaan.index') }}">Data Bentuk Sediaan</a></li>
                                <li><a href="{{ route('data-satuan.index') }}">Data Satuan</a></li>
                                <li><a href="{{ route('data-obat.index') }}">Data Obat</a></li>
                                <li><a href="{{ route('data-obat-masuk.index') }}">Data Obat Masuk</a></li>
                                <li><a href="{{ route('data-obat-keluar.index') }}">Data Obat Keluar</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-sip-line"></i>
                                <span>Bahan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('data-bahan.index') }}">Data Bahan</a></li>
                                <li><a href="{{ route('data-bahan-masuk.index') }}">Data Bahan Masuk</a></li>
                                <li><a href="{{ route('data-bahan-keluar.index') }}">Data Bahan Keluar</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('pengajuan-bahan.index') }}" class="waves-effect">
                                <i class="ri-book-mark-line"></i>
                                <span>Pengajuan Bahan Obat</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-pencil-ruler-2-line"></i>
                                <span>Alat</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('data-alat.index') }}">Data Asset (Alat)</a></li>
                                <li><a href="{{ route('data-alat-masuk.index') }}">Data Alat Masuk</a></li>
                                <li><a href="{{ route('data-alat-rusak.index') }}">Data Alat Rusak/Pecah</a></li>
                            </ul>
                        </li>
                        
                    @endrole

                    @role('Admin Lab')
                        <li>
                            <a href="{{ route('home') }}" class="waves-effect">
                                <i class="ri-home-line"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-contrast-fill"></i>
                                <span>Obat</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('data-kemasan.index') }}">Data Kemasan</a></li>
                                <li><a href="{{ route('data-bentuk-sediaan.index') }}">Data Bentuk Sediaan</a></li>
                                <li><a href="{{ route('data-satuan.index') }}">Data Satuan</a></li>
                                <li><a href="{{ route('data-obat.index') }}">Data Obat</a></li>
                                <li><a href="{{ route('data-obat-masuk.index') }}">Data Obat Masuk</a></li>
                                <li><a href="{{ route('data-obat-keluar.index') }}">Data Obat Keluar</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-sip-line"></i>
                                <span>Bahan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('data-bahan.index') }}">Data Bahan</a></li>
                                <li><a href="{{ route('data-bahan-masuk.index') }}">Data Bahan Masuk</a></li>
                                <li><a href="{{ route('data-bahan-keluar.index') }}">Data Bahan Keluar</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('pengajuan-bahan.index') }}" class="waves-effect">
                                <i class="ri-book-mark-line"></i>
                                <span>Pengajuan Bahan Obat</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-pencil-ruler-2-line"></i>
                                <span>Alat</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('data-alat.index') }}">Data Asset (Alat)</a></li>
                                <li><a href="{{ route('data-alat-masuk.index') }}">Data Alat Masuk</a></li>
                                <li><a href="{{ route('data-alat-rusak.index') }}">Data Alat Rusak/Pecah</a></li>
                            </ul>
                        </li>
                        
                    @endrole

                    @role('Administrasi')
                        <li>
                            <a href="{{ route('home') }}" class="waves-effect">
                                <i class="ri-home-line"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-article-line"></i>
                                <span>Surat</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('data-surat-masuk.index') }}">Surat Masuk</a></li>
                                <li><a href="{{ route('data-surat-keluar.index') }}">Surat Keluar</a></li>
                                <li><a href="{{ route('data-surat-penting.index') }}">Surat Penting</a></li>
                                <li><a href="{{ route('data-surat-sk.index') }}">Surat SK</a></li>
                                <li><a href="{{ route('data-surat-arsip.index') }}">Surat Arsip</a></li>
                                <li><a href="{{ route('data-surat-mou.index') }}">Surat MOU</a></li>
                            </ul>
                        </li>
                        
                    @endrole

                    @role('Mahasiswa')
                        <li>
                            <a href="{{ route('home') }}" class="waves-effect">
                                <i class="ri-home-line"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('pengajuan-bahan.index') }}" class=" waves-effect">
                                <i class="ri-book-2-line"></i>
                                <span>Pengajuan Bahan</span>
                            </a>
                        </li>
                    @endrole
                    
                @endguest

                
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->