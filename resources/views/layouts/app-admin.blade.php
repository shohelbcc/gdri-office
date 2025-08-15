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

    <!-- Jquery Core -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Axios -->
    <script src="{{ asset('assets/axios/axios.min.js') }}"></script>    

    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('assets/dataTable/datatables.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/Ionicons/css/ionicons.css') }}">

    <!-- perfect-scrollbar -->
    <link rel="stylesheet" href="{{ asset('assets/perfect-scrollbar/css/perfect-scrollbar.css') }}">

    <!-- select2 -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('assets/summernote/summernote-lite.min.css') }}">
    <script src="{{ asset('assets/summernote/summernote-lite.min.js') }}"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/all.min.css') }}">

    <!-- toastify -->
    <link rel="stylesheet" href="{{ asset('assets/toastify/toastify.min.css') }}">
    
    <!-- Summer Note -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- starlight -->
    <link rel="stylesheet" href="{{ asset('assets/starlight/starlight.css') }}">

    <!-- Additional Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/admin-custom/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-custom/custom.css') }}">

    <!-- stack -->
    @stack('styles')


</head>

<body class="font-sans antialiased">


    <!-- ########## START: Notification ########## -->
    @include('components.reload-notification')
    <!-- ########## END: Notification ########## -->

    <!-- ########## START: LEFT PANEL ########## -->
    @include('components.admin.side-navbar')
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    @include('components.admin.top-navbar')
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel bg-light">
        <div class="container-fluid pt-3" style="min-height: 88vh !important;">
            <div class="row">
                <div class="col-md-12">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('components.admin.footer')
                </div>
            </div>
        </div>
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->


    <!-- Data Table -->
    <script src="{{ asset('assets/dataTable/datatables.min.js') }}"></script>

    <!-- poper -->
    <script src="{{ asset('assets/popper/popper.js') }}"></script>

    <!-- textscroller -->
    <script src="{{ asset('assets/textscroller/jquery.jConveyorTicker.min.js') }}"></script>

    <!-- Select2 -->
    {{-- <script src="{{ asset('assets/select2/select2.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Tom Select -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- fontawesome -->
    <script src="{{ asset('assets/fontawesome/all.min.js') }}"></script>

    <!-- perfect-scrollbar -->
    <script src="{{ asset('assets/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}"></script>

    <!-- starlight -->
    <script src="{{ asset('assets/starlight/js/starlight.js') }}"></script>

    <!-- toastify -->
    <script src="{{ asset('assets/toastify/toastify-js.js') }}"></script>

    <!-- Summer Note -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <!-- Summer Note Initiate -->
    <script>
        $(document).ready(function () {
            $('.content').summernote({
                height: 150,
            });
        });
    </script>

    <!-- Additional Scripts -->
    <script src="{{ asset('assets/admin-custom/main.js') }}"></script>
    <script src="{{ asset('assets/admin-custom/custom.js') }}"></script>

    <!-- stack -->
    @stack('scripts')


</body>

</html>