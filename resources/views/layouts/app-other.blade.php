<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'BCC - ') }}
        @yield('title')
        @if (isset($title))
            {{ $title }}
        @endif
    </title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">

    <!-- Libraries stylesheet -->
    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('assets/lib/animate/animate.min.css') }}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}">
    <!-- tempusdominus -->
    <link rel="stylesheet" href="{{ asset('assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}">

    <!-- Additional Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- stack -->
    @stack('styles')

</head>

<body class="font-sans antialiased">

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- ########## START: Notification ########## -->
    @include('components.reload-notification')
    <!-- ########## END: Notification ########## -->

    <!-- Navbar Start -->
    @include('home.components.navbar')
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-6 text-white animated slideInDown">@yield('page-title')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">@yield('parent-page')</a></li>
                            <li class="breadcrumb-item text-primary active" aria-current="page">@yield('active-page')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Body Start -->
    @yield('content')
    <!-- Body End -->

    <!-- Footer Start -->
    @include('home.components.footer')
    <!-- Footer End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>







    <!-- jQuery Core -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    {{-- <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script> --}}

    <!-- Bootstrap -->    
    {{-- <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome -->
    <script src="{{ asset('assets/fontawesome/all.min.js') }}"></script>
    <!-- easing -->
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <!-- waypoints -->
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <!-- owlcarousel -->
    <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
    <!-- animate -->
    <script src="{{ asset('assets/lib/animate/animate.min.css') }}"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <!-- tempusdominus -->
    <script src="{{ asset('assets/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- counterup -->
    <script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
    <!-- isotope -->
    <script src="{{ asset('assets/lib/isotope/isotope.pkgd.min.js') }}"></script>


    <!-- Additional Scripts -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- stack -->
    @stack('scripts')

</body>

</html>