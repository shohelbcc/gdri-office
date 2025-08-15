@extends('layouts.app-home')
@section('content')
    <section id="postDetails" class="py-5 bg-gradient position-relative">
        <div class="container">
            <div class="row justify-content-center g-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-12 col-lg-10 d-flex align-items-stretch">
                    <div class="card post-details-card border-0 shadow-lg rounded-4 w-100 flex-lg-row flex-column overflow-hidden">
                        <div class="post-details-img-wrapper flex-shrink-0 d-flex align-items-center justify-content-center bg-light" style="min-width:320px;max-width:420px;">
                            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="img-fluid rounded-3 shadow-sm m-4" style="max-width:340px;max-height:340px;object-fit:cover;">
                        </div>
                        <div class="card-body d-flex flex-column p-4 position-relative flex-grow-1">
                            <h3 class="fw-bold text-primary mb-3">{{ $post->title }}</h3>
                            <div class="mb-3 text-secondary post-details-content" style="font-size:1.08rem;">{!! $post->content !!}</div>
                            <div class="d-flex flex-wrap align-items-center gap-3 mb-2">
                                <span class="badge bg-gradient text-white px-3 py-2 rounded-pill shadow-sm" style="background: linear-gradient(90deg, #06BBCC 0%, #3B82F6 100%);">Authors: {{ $post->author_names }}</span>
                                <span class="badge bg-light text-primary border px-3 py-2 rounded-pill shadow-sm">Category: {{ $post->category->name ?? 'Uncategorized' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="post-details-bg-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index:0;"></div>
    </section>
@endsection

@push('styles')
    <style>
        #postDetails {
            background: linear-gradient(120deg, #f8fafc 0%, #e0f7fa 100%);
            position: relative;
            overflow: hidden;
        }
        .post-details-bg-overlay {
            background: url('/images/post-details-bg.svg') center center/cover no-repeat;
            opacity: 0.08;
            pointer-events: none;
        }
        .post-details-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(6, 187, 204, 0.08), 0 1.5px 6px 0 rgba(59, 130, 246, 0.06);
            transition: transform 0.4s cubic-bezier(.4,2,.3,1), box-shadow 0.4s;
            z-index: 1;
            min-height: 320px;
        }
        .post-details-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 16px 48px 0 rgba(6, 187, 204, 0.16), 0 3px 12px 0 rgba(59, 130, 246, 0.12);
        }
        .post-details-img-wrapper {
            min-height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e9ecef;
        }
        .post-details-card .card-body {
            font-size: 1.08rem;
        }
        .post-details-card .badge {
            font-size: 0.95rem;
            background: linear-gradient(90deg, #06BBCC 0%, #3B82F6 100%) !important;
            color: #fff !important;
            box-shadow: 0 2px 8px 0 rgba(6, 187, 204, 0.10);
        }
        .post-details-card .badge.bg-light {
            color: #3B82F6 !important;
            background: #f8fafc !important;
            border: 1px solid #3B82F6 !important;
        }
        .post-details-content {
            text-align: justify;
        }
        @media (max-width: 991.98px) {
            .post-details-card { flex-direction: column !important; min-height: 220px; }
            .post-details-img-wrapper { min-width:100%; max-width:100%; min-height:180px; }
            .post-details-img-wrapper img { margin: 0 auto; }
        }
        @media (max-width: 575.98px) {
            .post-details-card { min-height: 180px; }
        }
    </style>
@endpush