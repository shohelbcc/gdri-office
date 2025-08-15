<div id="currentInitiatives" class="dark_section py-5 bg-light">
    <div class="container">
        <div class="row wow fadeInUp mb-4" data-wow-delay="0.1s">
            <div class="col-md-12 text-center">
                <h2 class="section_title_light">Current Initiatives</h2>
                <p class="fw-bold">Ongoing and Completed Researches</p>
            </div>
        </div>
        <div class="row wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-md-12">
                <div style="max-width: 100vw !important; overflow: hidden;">
                    <div class="owl-carousel current-initiatives-carousel">
                        @foreach (getAllProjects() as $key => $project)
                            <div class="carousel-item active">
                                <a href="" style="text-decoration: none; color: inherit;">
                                    <div class="card h-100">
                                        <div class="card-header border-0 p-0 overflow-hidden">
                                            <img src="{{ asset($project['featured_image']) }}" alt="" class="img-fluid">
                                        </div>
                                        <div class="card-body h-100">
                                            <h5 class="card-title text-primary">{{ $project['title'] }}</h5>
                                            <p class="text-justify">{!! $project['details'] !!}</p>
                                            <p class=""><span class="fw-bold">Study Area:</span>
                                                {{ $project['study_area'] }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            // current-initiatives-carousel
            $(".current-initiatives-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1500,
                center: true,
                dots: true,
                loop: true,
                margin: 15,
                responsiveClass: true,
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    992: { items: 3 }
                },
                nav: true,
                navText: [
                    '<i class="bi bi-chevron-left"></i>',
                    '<i class="bi bi-chevron-right"></i>'
                ]
            });
        });
    </script>

@endpush

@push('styles')
    <style>
        .current-initiatives-carousel .owl-nav {
            position: relative;
            height: 70px;
            width: 100px;
        }

        .current-initiatives-carousel .owl-nav .owl-prev {
            position: absolute;
            bottom: 50%;
            left: 0;
            transform: translateY(50%);
            background: #06BBCC;
            height: 30px;
            width: 40px;
            color: #fff;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }

        .current-initiatives-carousel .owl-nav .owl-next {
            position: absolute;
            bottom: 50%;
            right: 0;
            transform: translateY(50%);
            background: #06BBCC;
            height: 30px;
            width: 40px;
            color: #fff;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }
    </style>

@endpush