<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="STIKes Sambas" />

        <!-- Site Title -->
        <title>Beranda - STIKes Sambas</title>
        <!-- Site favicon -->
        <link rel="shortcut icon" href="{{ asset('logo-stikes.png') }}">

        <!-- Light-box -->
        <link rel="stylesheet" href="{{ asset('asset-dojek/css/mklb.css') }}" type="text/css" />

        <!-- Swiper js -->
        <link rel="stylesheet" href="{{ asset('asset-dojek/css/swiper-bundle.min.css') }}" type="text/css" />

        <!--Material Icon -->
        <link rel="stylesheet" type="text/css" href="{{ asset('asset-dojek/css/materialdesignicons.min.css') }}" />

        <link rel="stylesheet" type="text/css" href="{{ asset('asset-dojek/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('asset-dojek/css/style.css') }}" />
    </head>

    <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="60">
        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky-dark" id="navbar-sticky">
            <div class="container">
                <!-- LOGO -->
                <a class="logo text-uppercase" href="index-1.html">
                    <img src="images/logo-dark.png" alt=""/>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto navbar-center" id="mySidenav">
                        <li class="nav-item">
                            <a href="#home" class="nav-link">Beranda</a>
                        </li>

                        @guest
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">keluar</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- home-agency start -->
        <section class="hero-2" id="home">
           <div class="container">
               <div class="row align-items-center">
                   <div class="col-lg-6">
                       <h1 class="display-4 mb-4 fw-semibold">Selamat Datang Di <span class="text-primary">SIM STIKES HUB</span></h1>
                       <p class="text-muted fs-18">Sekolah Tinggi Ilmu Kesehatan Sambas.</p>
                       <a href="{{ route('home') }}" class="btn btn-lg btn-gradient-success mt-4">Masuk Sekarang <i class="mdi mdi-arrow-right fs-14 ms-1"></i></a>
                   </div>

                   <div class="col-lg-6">
                       <div class="hero-2-img-bg mt-4 mt-lg-0">
                           <img src="{{ asset('asset-dojek/images/heros/14429.png') }}" alt="" class="img-fluid">
                       </div>
                   </div>
               </div>
           </div>
        </section>
        <!-- home-agency end -->

        <!-- Back to top -->
        <a href="#" onclick="topFunction()" class="back-to-top-btn btn btn-dark" id="back-to-top"><i class="mdi mdi-chevron-up"></i></a>

        <!-- javascript -->
        <script src="{{ asset('asset-dojek/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Portfolio filter -->
        <script src="{{ asset('asset-dojek/js/filter.init.js') }}"></script>
        <!-- Light-box -->
        <script src="{{ asset('asset-dojek/js/mklb.js') }}"></script>
        <!-- swiper -->
        <script src="{{ asset('asset-dojek/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('asset-dojek/js/swiper.js') }}"></script>

        <!-- counter -->
        <script src="{{ asset('asset-dojek/js/counter.init.js') }}"></script>
        <script src="{{ asset('asset-dojek/js/app.js') }}"></script>
    </body>
</html>
