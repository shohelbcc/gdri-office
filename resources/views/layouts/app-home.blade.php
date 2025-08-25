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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SN69ZG0MMK"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-SN69ZG0MMK');
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">

    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('assets/lib/animate/animate.min.css') }}">

    <!-- Libraries stylesheet -->
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
    @include('components.home.nav')
    <!-- Navbar End -->

    <!-- Hero Start -->
    <div class="container-fluid p-0" style="padding-top: 70px !important;">
        {{-- Hero Section - Only show on home page --}}
        @if(request()->routeIs('home'))
            @include('components.home.hero')
        @else
            @include('components.home.page-header')
        @endif        
    </div>
    <!-- Hero End -->

    <!-- Body Start -->
    @yield('content') 
    <!-- Body End -->

    <!-- Subscription Start -->
    @include('home.components.subscription')
    <!-- Subscription End -->

    <!-- Footer Start -->
    @include('components.home.footer')
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