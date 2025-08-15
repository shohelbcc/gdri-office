@extends('layouts.app-home')
@section('content')
    <section id="impactStory" class="py-5 bg-gradient position-relative">
        <div class="container">
            <div class="row g-4 justify-content-center">
                @foreach ($impactStories as $item)
                    <div class="col-12 d-flex align-items-stretch wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card impact-story-card border-0 shadow-lg rounded-4 w-100">
                            <div class="card-body p-4 position-relative">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-gradient text-white px-3 py-2 rounded-pill shadow-sm me-2" style="background: linear-gradient(90deg, #06BBCC 0%, #3B82F6 100%); font-size:0.95rem;">Reference:</span>
                                    <span class="text-muted small">{!! $item->reference !!}</span>
                                </div>
                                <h5 class="fw-bold text-primary mb-2">{!! $item->title !!}</h5>
                                <p class="mb-0 text-secondary">{!! $item->description !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="impact-bg-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index:0;"></div>
    </section>
@endsection

@push('styles')
<style>
    #impactStory {
        background: linear-gradient(120deg, #f8fafc 0%, #e0f7fa 100%);
        position: relative;
        overflow: hidden;
    }
    .impact-bg-overlay {
        background: url('/images/impact-bg.svg') center center/cover no-repeat;
        opacity: 0.08;
        pointer-events: none;
    }
    .impact-story-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(6, 187, 204, 0.08), 0 1.5px 6px 0 rgba(59, 130, 246, 0.06);
        transition: transform 0.4s cubic-bezier(.4,2,.3,1), box-shadow 0.4s;
        z-index: 1;
    }
    .impact-story-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 16px 48px 0 rgba(6, 187, 204, 0.16), 0 3px 12px 0 rgba(59, 130, 246, 0.12);
    }
    .impact-story-card .card-body {
        font-size: 1.08rem;
    }
    .impact-story-card .badge {
        font-size: 0.95rem;
        background: linear-gradient(90deg, #06BBCC 0%, #3B82F6 100%) !important;
        color: #fff !important;
        box-shadow: 0 2px 8px 0 rgba(6, 187, 204, 0.10);
    }
    @media (max-width: 991.98px) {
        .impact-story-card { min-height: 220px; }
    }
    @media (max-width: 575.98px) {
        .impact-story-card { min-height: 180px; }
    }
</style>
@endpush