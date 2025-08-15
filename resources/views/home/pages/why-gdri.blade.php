@extends('layouts.app-home')
@section('content')
    <section id="whyGdri" class="py-5 bg-gradient position-relative">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-12 d-flex align-items-stretch">
                    <div class="card why-gdri-card border-0 shadow-lg rounded-2 w-100 py-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body p-4 position-relative">
                            <div class="why-gdri-description text-secondary" style="font-size:1.12rem;">
                                {!! $mainContent->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="why-gdri-bg-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index:0;"></div>
    </section>
@endsection

@push('styles')
<style>
    #whyGdri {
        background: linear-gradient(120deg, #f8fafc 0%, #e0f7fa 100%);
        position: relative;
        overflow: hidden;
    }
    .why-gdri-bg-overlay {
        background: url('/images/why-gdri-bg.svg') center center/cover no-repeat;
        opacity: 0.08;
        pointer-events: none;
    }
    .why-gdri-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(6, 187, 204, 0.08), 0 1.5px 6px 0 rgba(59, 130, 246, 0.06);
        transition: transform 0.4s cubic-bezier(.4,2,.3,1), box-shadow 0.4s;
        z-index: 1;
    }
    .why-gdri-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 16px 48px 0 rgba(6, 187, 204, 0.16), 0 3px 12px 0 rgba(59, 130, 246, 0.12);
    }
    .why-gdri-card .badge {
        font-size: 0.95rem;
        background: linear-gradient(90deg, #06BBCC 0%, #3B82F6 100%) !important;
        color: #fff !important;
        box-shadow: 0 2px 8px 0 rgba(6, 187, 204, 0.10);
    }
    .why-gdri-description {
        text-align: justify;
    }
    @media (max-width: 991.98px) {
        .why-gdri-card { min-height: 220px; }
    }
    @media (max-width: 575.98px) {
        .why-gdri-card { min-height: 180px; }
    }
</style>
@endpush