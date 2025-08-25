<!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow fixed-top p-0">
        <div class="container-fluid">
            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 110px; height: auto;">
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">Our Impact</a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="{{ route('why.gdri') }}" class="dropdown-item ">Why GDRI?</a>
                            <a href="{{ route('impact.story') }}" class="dropdown-item ">Impact Stories</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">Projects</a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="{{ route('ongoing.projects') }}" class="dropdown-item ">Ongoing Projects</a>
                            <a href="{{ route('completed.projects') }}" class="dropdown-item ">Completed Projects</a>
                            <a href="{{ route('publication.report') }}" class="dropdown-item ">Publications & Reports</a>
                        </div>
                    </div>
                    <a href="{{ route('services') }}" class="nav-item nav-link ">Services</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">Media</a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="{{ route('blog.news') }}" class="dropdown-item ">Blog & News</a>
                            <a href="{{ route('gallery') }}" class="dropdown-item ">Gallery</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">About</a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="{{ route('our.story') }}" class="dropdown-item ">Our Story</a>
                            <a href="{{ route('branches') }}" class="dropdown-item ">Branches</a>
                        </div>
                    </div>
                    <a href="{{ route('get.experience.certificate') }}" class="btn btn-sm btn-primary d-flex justify-content-center align-items-center" style="max-height:50px;height:100%;margin:auto 0">Experience Certificate</a>
                </div>
                <!-- <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a> -->
            </div>
        </div>
    </nav>
    <!-- Navbar End -->