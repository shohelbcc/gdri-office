@extends('layouts.app-home')
@section('content')
    <section id="completeProjects" class="py-5 bg-gradient position-relative">
        <div class="container">
            <div class="row g-4 flex-column wow fadeInUp" data-wow-delay="0.1s">
                @foreach ($completedProjects as $item)
                    <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                        <a href="{{ route('project.details', $item['id']) }}" class="project-link w-100 text-decoration-none text-dark">
                            <div class="card ongoing-project-row-card border-0 shadow-lg rounded-4 w-100 h-100 mb-4">
                                <div class="project-image-row d-flex align-items-center justify-content-center pt-4 flex-shrink-0" style="min-width:160px;max-width:220px;">
                                    <img src="{{ $item['featured_image'] }}" alt="Featured Image" class="img-fluid rounded-3 shadow-sm" style="max-width:140px;max-height:140px;object-fit:cover;">
                                </div>
                                <div class="card-body d-flex flex-column p-4 position-relative flex-grow-1">
                                    <h5 class="card-title fw-bold text-primary mb-2">{{ Str::limit($item['title'], 40) }}</h5>
                                    <div class="project-meta mb-2">
                                        <span class="badge bg-light text-primary border px-3 py-2 rounded-pill shadow-sm">Status: {{ $item['status'] }}</span>
                                        <span class="badge bg-light text-primary border px-3 py-2 rounded-pill shadow-sm">Study Area: {{ $item['study_area'] }}</span>
                                    </div>
                                    <p class="card-text text-secondary mt-2 mb-3" style="min-height: 80px;">{!! Str::limit($item['details'], 180) !!}</p>
                                    <div class="mt-auto">
                                        <button class="btn btn-outline-primary btn-sm rounded-pill px-4">View Details <i class="fa-solid fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="ongoing-bg-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index:0;"></div>
    </section>
@endsection

@push('styles')
<style>
    #completeProjects {
        background: linear-gradient(120deg, #f8fafc 0%, #e0f7fa 100%);
        position: relative;
        overflow: hidden;
    }
    .ongoing-bg-overlay {
        background: url('/images/ongoing-bg.svg') center center/cover no-repeat;
        opacity: 0.08;
        pointer-events: none;
    }
    .ongoing-project-row-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 32px 0 rgba(6, 187, 204, 0.08), 0 1.5px 6px 0 rgba(59, 130, 246, 0.06);
        transition: transform 0.4s cubic-bezier(.4,2,.3,1), box-shadow 0.4s;
        z-index: 1;
        min-height: 180px;
    }
    .ongoing-project-row-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 16px 48px 0 rgba(6, 187, 204, 0.16), 0 3px 12px 0 rgba(59, 130, 246, 0.12);
    }
    .ongoing-project-row-card .card-title {
        font-size: 1.2rem;
        letter-spacing: 0.5px;
    }
    .ongoing-project-row-card .project-meta .badge {
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }
    .ongoing-project-row-card .btn {
        font-size: 0.98rem;
        font-weight: 500;
        box-shadow: 0 2px 8px 0 rgba(6, 187, 204, 0.10);
    }
    .ongoing-project-row-card .btn i {
        font-size: 1rem;
    }
    .project-image-row img {
        border-radius: 0.75rem;
        background: #f0f8ff;
        border: 1.5px solid #e0f7fa;
    }
    @media (max-width: 991.98px) {
        .ongoing-project-row-card { flex-direction: column !important; min-height: 320px; }
        .project-image-row { justify-content: flex-start !important; min-width:100%; max-width:100%; padding-bottom:0; }
        .project-image-row img { margin: 0 auto; }
    }
    @media (max-width: 575.98px) {
        .ongoing-project-row-card { min-height: 220px; }
    }
</style>
@endpush