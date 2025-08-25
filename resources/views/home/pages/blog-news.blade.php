@extends('layouts.app-home')
@section('content')
    <section id="blogPost" class="py-5 bg-gradient position-relative">
        <div class="container">
            <div class="row g-4 justify-content-center wow fadeInUp" data-wow-delay="0.1s">
                @forelse ($posts as $item)
                    <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                        <a href="{{ route('post.details', $item->slug) }}" class="w-100 text-decoration-none text-dark">
                            <div class="card blogPost-card border-0 shadow-lg rounded-4 w-100 h-100 animate__animated animate__fadeInUp">
                                <div class="blogPost-img-wrapper position-relative">
                                    <img src="{{ $item->featured_image }}" alt="{{ $item->title }}" class="card-img-top blogPost-img">
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold text-primary mb-2">{{ Str::limit($item->title, 25) }}</h5>
                                    <div class="card-text flex-grow-1 mb-2 text-secondary" style="min-height: 70px;">
                                        {!! Str::limit(strip_tags($item->content), 100) !!}
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <span class="badge bg-light text-primary border px-3 py-2 rounded-pill shadow-sm">Category: {{ $item->category->name ?? 'Uncategorized' }}</span>
                                        <span class="badge bg-light text-primary border px-3 py-2 rounded-pill shadow-sm">Author: {{ $item->author_names ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="mt-2 text-end">
                                        <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $item->published_at ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-warning">No posts found.</div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="blog-news-bg-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index:0;"></div>
    </section>
@endsection

@push('styles')
    <style>
        #blogPost {
            background: linear-gradient(120deg, #f8fafc 0%, #e0f7fa 100%);
            position: relative;
            overflow: hidden;
        }

        .blog-news-bg-overlay {
            background: url('/images/blog-news-bg.svg') center center/cover no-repeat;
            opacity: 0.08;
            pointer-events: none;
        }

        .blogPost-card {
            border-radius: 10px;
            overflow: hidden;
            transition: box-shadow 0.3s, transform 0.3s;
            background: #fff;
            box-shadow: 0 8px 32px 0 rgba(6, 187, 204, 0.08), 0 1.5px 6px 0 rgba(59, 130, 246, 0.06);
            position: relative;
        }

        .blogPost-card:hover {
            box-shadow: 0 16px 48px 0 rgba(6, 187, 204, 0.16), 0 3px 12px 0 rgba(59, 130, 246, 0.12);
            transform: translateY(-6px) scale(1.03);
        }

        .blogPost-img-wrapper {
            height: 220px;
            overflow: hidden;
            background: #e9ecef;
        }

        .blogPost-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .blogPost-card:hover .blogPost-img {
            transform: scale(1.08) rotate(-1deg);
        }

        .blogPost-status {
            font-size: 0.95rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(6, 187, 204, 0.08);
            letter-spacing: 0.5px;
        }

        .blogPost-card .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .blogPost-card .card-text {
            font-size: 1rem;
            color: #555;
        }

        @media (max-width: 991.98px) {
            .blogPost-card {
                min-height: 340px;
            }

            .blogPost-img-wrapper {
                height: 160px;
            }

            .blogPost-card .card-title {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 575.98px) {
            .blogPost-card {
                min-height: 220px;
            }
        }
    </style>
@endpush