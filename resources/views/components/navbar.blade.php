<div class="st-height-70"></div>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="logo-light" height="20">
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
                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
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
                        <a class="dropdown-item" href="{{ url('/') }}"><i class="ri-user-line align-middle me-1"></i> Dashboard</a>
                        <a class="dropdown-item" href="{{ route('home') }}"><i class="ri-user-line align-middle me-1"></i> Dashboard</a>
                        <li><a class="dropdown-item" href="{{ route('login') }}">Masuk</a></li>
                    @else
                        <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Dashboard</a>
                        <a class="dropdown-item" href=""><i class="ri-wallet-2-line align-middle me-1"></i> Profil</a>
                                
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Keluar </a>
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
                    @role('Admin Lab')
                        <li>
                            <a href="{{ route('home') }}" class="waves-effect">
                                <i class="ri-dashboard-line"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('data-obat.index') }}" class=" waves-effect">
                                <i class="ri-user-2-line"></i>
                                <span>Data Kemasan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('data-obat.index') }}" class=" waves-effect">
                                <i class="ri-user-2-line"></i>
                                <span>Data Bentuk Sediaan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('data-obat.index') }}" class=" waves-effect">
                                <i class="ri-user-2-line"></i>
                                <span>Data Satuan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('data-obat.index') }}" class=" waves-effect">
                                <i class="ri-user-2-line"></i>
                                <span>Data Obat</span>
                            </a>
                        </li>
            
                        <li>
                            <a href="{{  route('data-obat-masuk.index')}}" class=" waves-effect">
                                <i class="ri-key-2-line"></i>
                                <span>Data Obat Masuk</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('data-obat-keluar.index') }}" class=" waves-effect">
                                <i class="ri-map-2-line"></i>
                                <span>Data Obat Keluar</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('pengajuan-bahan.index') }}" class=" waves-effect">
                                <i class="ri-book-2-line"></i>
                                <span>Pengajuan Bahan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('pengajuan-bahan.index') }}" class=" waves-effect">
                                <i class="ri-book-2-line"></i>
                                <span>Pengajuan Bahan</span>
                            </a>
                        </li>
                        
                    @endrole

                    @role('Mahasiswa')
                        <li>
                            <a href="{{ route('home') }}" class="waves-effect">
                                <i class="ri-dashboard-line"></i>
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