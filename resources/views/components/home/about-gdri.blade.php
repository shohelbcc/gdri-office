<div id="aboutComponent" class="dark_section py-5">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-md-12 text-center">
                <h2 class="section_title_dark">About GDRI</h2>
                <p class="fw-bold mb-0 text-light">{{ getHomeAccordionFirstItem()->title }}</p>
                <p class="text-light">{{ getHomeAccordionFirstItem()->content }}</p>
            </div>
        </div>
        <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-md-12">
                <div class="accordion shadow-sm" id="aboutAccordion">
                    @foreach (getHomeAccordionItems() as $key => $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $item['id'] }}">
                                <button class="accordion-button {{ $key === 0 ? '' : 'collapsed' }} fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $item['id'] }}"
                                    aria-expanded="{{ $key === 0 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $item['id'] }}">
                                    {{ $item['title'] }}
                                </button>
                            </h2>
                            <div id="collapse{{ $item['id'] }}"
                                class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}"
                                aria-labelledby="heading{{ $item['id'] }}" data-bs-parent="#aboutAccordion">
                                <div class="accordion-body text-white">
                                    {!! $item['content'] !!}
                                </div>
                            </div>
                        </div>


                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        #aboutComponent {
            background: linear-gradient(rgba(20, 20, 31, .7), rgba(20, 20, 31, .7)), url('/images/about-gdri-bg.jpg');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: 100%;
            animation: bg-zoom 25s ease-in-out infinite alternate;
            min-height: 60vh;
            position: relative;
            background-attachment: fixed;
        }

        #aboutComponent .accordion-button:not(.collapsed) {
            background: #06BBCC !important;
            color: #fff;
        }

        #aboutComponent .accordion-button.collapsed {
            background: #ffffff !important;
            color: #000;
        }

        #aboutComponent .accordion-body {
            background: #f8fafc;
        }

        #aboutComponent .accordion-button:focus {
            box-shadow: none !important;
        }

        /* .accordion .accordion-body{
            border : 1px solid #06BBCC !important;
        }
        .accordion .accordion-item, .accordion .accordion-body {
            background: transparent !important;
        }

        .accordion .accordion-body.text-white p span {
            color: #fff !important;
        } */
    </style>

@endpush