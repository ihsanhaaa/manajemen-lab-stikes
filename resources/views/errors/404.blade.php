<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="STIKes Sambas" />

        <!-- Site Title -->
        <title>404 Not Found</title>
        <!-- Site favicon -->
        <link rel="shortcut icon" href="{{ asset('asset-dojek/images/favicon.ico') }}" />

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
        
        <!-- Projects start -->
        <section class="section" id="projects">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-8 col-lg-6 text-center">
                        <img src="{{ asset('404.png') }}" alt="" class="img-fluid">
                        <h5 class="subtitle mt-3">Uppss, halaman yang anda cari tidak ada!!</h5>
                        <a href="{{ route('home') }}" class="btn btn-success mt-3"> Kembali ke halaman Dashboard</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Projects end -->

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
