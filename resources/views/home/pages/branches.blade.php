@extends('layouts.app-home')
@section('content')
    <section id="branch" class="py-5 bg-gradient position-relative">
        <div class="container">
            <div class="row g-4 justify-content-center wow fadeInUp" data-wow-delay="0.1s">
                @foreach ($branches as $branch)
                    <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                        <div class="card branch-card border-0 shadow-lg rounded-4 w-100">
                            <div class="card-body d-flex flex-column justify-content-between p-4 position-relative">
                                <div class="branch-icon mb-3 text-center">
                                    <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle shadow-lg" style="width:64px;height:64px;font-size:2rem;">
                                        <i class="fa-solid fa-building"></i>
                                    </span>
                                </div>
                                <h5 class="card-title text-center fw-bold text-dark mb-2">{{ $branch->name }}</h5>
                                <ul class="list-unstyled mt-3 mb-4 text-center">
                                    <li class="mb-2"><i class="fa-solid fa-phone-volume me-2 text-primary"></i> <span class="fw-semibold">{{ $branch->phone }}</span></li>
                                    <li class="mb-2"><i class="fa-solid fa-envelope me-2 text-primary"></i> <span class="fw-semibold">{{ $branch->email }}</span></li>
                                    <li><i class="fa-solid fa-location-dot me-2 text-primary"></i> <span class="fw-semibold">{{ $branch->location }}</span></li>
                                </ul>
                                <div class="text-center mt-auto">
                                    <span class="badge bg-gradient text-white px-3 py-2 rounded-pill shadow-sm" style="background: linear-gradient(90deg, #06BBCC 0%, #3B82F6 100%);">Branch</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="branch-bg-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index:0;"></div>
    </section>
@endsection

@push('styles')
    <style>
        #branch {
            background: linear-gradient(120deg, #f8fafc 0%, #e0f7fa 100%);
            position: relative;
            overflow: hidden;
        }
        .branch-bg-overlay {
            background: url('/images/branch-bg.svg') center center/cover no-repeat;
            opacity: 0.08;
            pointer-events: none;
        }
        .branch-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(6, 187, 204, 0.08), 0 1.5px 6px 0 rgba(59, 130, 246, 0.06);
            transition: transform 0.4s cubic-bezier(.4,2,.3,1), box-shadow 0.4s;
            z-index: 1;
        }
        .branch-card:hover {
            transform: translateY(-8px) scale(1.04);
            box-shadow: 0 16px 48px 0 rgba(6, 187, 204, 0.16), 0 3px 12px 0 rgba(59, 130, 246, 0.12);
        }
        .branch-icon {
            z-index: 2;
        }
        .branch-card .card-title {
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }
        .branch-card ul {
            font-size: 1.05rem;
        }
        .branch-card .badge {
            font-size: 0.95rem;
            background: linear-gradient(90deg, #06BBCC 0%, #3B82F6 100%) !important;
            color: #fff !important;
            box-shadow: 0 2px 8px 0 rgba(6, 187, 204, 0.10);
        }
        @media (max-width: 991.98px) {
            .branch-card { min-height: 340px; }
        }
        @media (max-width: 575.98px) {
            .branch-card { min-height: 280px; }
        }
    </style>
@endpush