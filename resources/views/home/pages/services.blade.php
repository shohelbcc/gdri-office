@extends('layouts.app-home')
@section('content')
    <section id="service" class="py-5 bg-gradient position-relative">
        <div class="container">
            <div class="row g-4 justify-content-center wow fadeInUp" data-wow-delay="0.1s">
                @forelse ($services as $item)
                    <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                        <a href="{{ route('service.details', $item->id) }}" class="w-100 text-decoration-none text-dark">
                            <div class="card service-card border-0 shadow-lg rounded-4 w-100 h-100">
                                <div class="service-img-wrapper position-relative">
                                    <img src="{{ $item->banner }}" alt="{{ $item->title }}" class="card-img-top service-img">
                                    <span class="service-status badge bg-{{ $item->status === 'active' ? 'success' : 'warning' }} position-absolute top-0 end-0 m-2 px-3 py-2">{{ ucfirst($item->status) }}</span>
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold text-primary mb-2">{{ Str::limit($item->title, 40) }}</h5>
                                    <div class="card-text flex-grow-1 mb-2 text-secondary" style="min-height: 70px;">
                                        {{ Str::limit(strip_tags($item->description), 100) }}
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
                                        <span class="badge bg-info text-dark px-3 py-2"><i class="bi bi-gear me-1"></i>Service</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-warning">No services found.</div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="service-bg-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index:0;"></div>
    </section>
@endsection

@push('styles')
    <style>
        #service {
            background: linear-gradient(120deg, #f8fafc 0%, #e0f7fa 100%);
            position: relative;
            overflow: hidden;
        }

        .service-bg-overlay {
            background: url('/images/service-bg.svg') center center/cover no-repeat;
            opacity: 0.08;
            pointer-events: none;
        }

        .service-card {
            border-radius: 10px;
            overflow: hidden;
            transition: box-shadow 0.3s, transform 0.3s;
            background: #fff;
            box-shadow: 0 8px 32px 0 rgba(6, 187, 204, 0.08), 0 1.5px 6px 0 rgba(59, 130, 246, 0.06);
            position: relative;
        }

        .service-card:hover {
            box-shadow: 0 16px 48px 0 rgba(6, 187, 204, 0.16), 0 3px 12px 0 rgba(59, 130, 246, 0.12);
            transform: translateY(-6px) scale(1.03);
        }

        .service-img-wrapper {
            height: 220px;
            overflow: hidden;
            background: #e9ecef;
        }

        .service-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .service-card:hover .service-img {
            transform: scale(1.08) rotate(-1deg);
        }

        .service-status {
            font-size: 0.95rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(6, 187, 204, 0.08);
            letter-spacing: 0.5px;
        }

        .service-card .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .service-card .card-text {
            font-size: 1rem;
            color: #555;
        }

        @media (max-width: 991.98px) {
            .service-card {
                min-height: 340px;
            }

            .service-img-wrapper {
                height: 160px;
            }

            .service-card .card-title {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 575.98px) {
            .service-card {
                min-height: 220px;
            }
        }
    </style>
@endpush