<div id="client" class="dark_section py-5 bg-light">
    <div class="container">
        <div class="row wow fadeInUp mb-4" data-wow-delay="0.1s">
            <div class="col-md-12 text-center">
                <h2 class="section_title_dark text-light">Our Clients</h2>
                <p class="fw-bold mt-4 text-light">Project and Research</p>
            </div>
        </div>
        <div class="row wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-md-12">
                <div style="max-width: 100vw !important; overflow: hidden;">
                    <div class="owl-carousel clients">
                        @foreach (getAllClients() as $key => $client)
                            <div class="carousel-item active">
                                <a href="" style="text-decoration: none; color: inherit;">
                                    <div class="card h-100">
                                        <div class="card-body border-0 p-0 overflow-hidden">
                                            <img src="{{ asset($client['logo']) }}" alt="" class="img-fluid">
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
            // clients
            $(".clients").owlCarousel({
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
                    768: { items: 3 },
                    992: { items: 5 },
                    1200: { items: 7 }
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
        #client {
            background-image: linear-gradient(rgba(20, 20, 31, .7), rgba(20, 20, 31, .7)), url('/images/clients-bg.jpg');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        .clients .owl-nav {
            position: relative;
            height: 70px;
            width: 100px;
            margin-left: auto;
        }

        .clients .owl-nav .owl-prev {
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

        .clients .owl-nav .owl-next {
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