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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="{{ asset('assets/fontawesome/all.min.css') }}">

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

        @yield('content')

        <!-- jQuery Core -->
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

        <!-- Bootstrap -->   
        <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <!-- FontAwesome -->
        <script src="{{ asset('assets/fontawesome/all.min.js') }}"></script>
        <!-- easing -->
        <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
        <!-- waypoints -->
        <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
        <!-- owlcarousel -->
        <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
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
