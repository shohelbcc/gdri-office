@extends('layouts.app-home')
@section('content')

    <!-- District Coverage Start -->
    {{-- @include('components.home.district-coverage') --}}
    <!-- District Coverage End -->

        <!-- Service Start -->
        {{-- @include('components.home.about-gdri') --}}
    <!-- Service End -->

    <!-- Current Initiatives Start -->
    {{-- @include('components.home.current-initiatives') --}}
    <!-- Current Initiatives End -->

    <div class="container py-5">
        <h1 class="text-center mb-4" style="font-weight:700;letter-spacing:1px;color:#0d6efd;">GDRI Photo Gallery</h1>
        <p class="text-center text-muted mb-4">Explore our work, events, and community impact</p>
        
        <!-- Filter Buttons -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-5" id="gallery-filters">
            <button class="btn btn-outline-primary btn-sm active" data-filter="all">All Photos</button>
            <button class="btn btn-outline-primary btn-sm" data-filter="research">Research</button>
            <button class="btn btn-outline-primary btn-sm" data-filter="community">Community</button>
            <button class="btn btn-outline-primary btn-sm" data-filter="training">Training</button>
            <button class="btn btn-outline-primary btn-sm" data-filter="events">Events</button>
        </div>
        
        <div id="lightgallery" class="row g-3 justify-content-center">
            @php
            $galleryImages = [
                ['src'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80','thumb'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80','title'=>'Research Team Meeting','category'=>'research'],
                ['src'=>'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80','thumb'=>'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400&q=80','title'=>'Community Workshop','category'=>'community'],
                ['src'=>'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&q=80','thumb'=>'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&q=80','title'=>'Team Collaboration','category'=>'research'],
                ['src'=>'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=800&q=80','thumb'=>'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=400&q=80','title'=>'Training Session','category'=>'training'],
                ['src'=>'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80','thumb'=>'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400&q=80','title'=>'Conference Presentation','category'=>'events'],
                ['src'=>'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&q=80','thumb'=>'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=400&q=80','title'=>'Field Research','category'=>'research'],
            ];
            @endphp
            @foreach($galleryImages as $img)
            <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="{{ $img['category'] }}">
                <a href="{{ $img['src'] }}" data-lg-size="1200-800" data-sub-html="<h4>{{ $img['title'] }}</h4><p>{{ ucfirst($img['category']) }} Activity</p>">
                    <div class="gallery-item-wrapper position-relative overflow-hidden rounded-3 shadow-sm">
                        <img src="{{ $img['thumb'] }}" alt="{{ $img['title'] }}" class="img-fluid w-100 gallery-image" loading="lazy" style="height: 220px; object-fit: cover; transition: all 0.3s ease;">
                        <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, rgba(13,110,253,0.8), rgba(108,117,125,0.6)); opacity: 0; transition: all 0.3s ease;">
                            <i class="fas fa-search-plus text-white mb-2" style="font-size: 1.8rem;"></i>
                            <h6 class="text-white text-center mb-1">{{ $img['title'] }}</h6>
                            <small class="text-white-50">{{ ucfirst($img['category']) }}</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css" />
    <style>
    .gallery-item-wrapper:hover .gallery-image { 
        transform: scale(1.05); 
    }
    .gallery-item-wrapper:hover .gallery-overlay { 
        opacity: 1 !important; 
    }
    .gallery-item-wrapper { 
        cursor: pointer; 
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .gallery-item-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .gallery-filters .btn {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .gallery-filters .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
    .gallery-filters .btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }
    .gallery-item {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    .gallery-item.filtered {
        opacity: 0;
        transform: translateY(20px) scale(0.9);
    }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize LightGallery
        const galleryElement = document.getElementById('lightgallery');
        const lightGalleryInstance = lightGallery(galleryElement, {
            selector: 'a',
            plugins: [lgZoom, lgThumbnail],
            speed: 400,
            download: false,
            thumbnail: true,
            zoom: true,
            actualSize: false,
            mode: 'lg-fade'
        });

        // Filter functionality with smooth animations
        const filterButtons = document.querySelectorAll('#gallery-filters .btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Add click ripple effect
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
                
                // Update active button with smooth transition
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.transform = 'scale(1)';
                });
                this.classList.add('active');

                // Hide all items first with fade out animation
                galleryItems.forEach(item => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px) scale(0.9)';
                });

                // Show filtered items after a delay with staggered animation
                setTimeout(() => {
                    let delay = 0;
                    galleryItems.forEach((item, index) => {
                        if (filter === 'all' || item.getAttribute('data-category') === filter) {
                            item.classList.remove('filtered');
                            item.style.display = 'block';
                            
                            // Staggered animation for visible items
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0) scale(1)';
                            }, delay);
                            delay += 100; // 100ms delay between each item
                        } else {
                            item.classList.add('filtered');
                            setTimeout(() => {
                                item.style.display = 'none';
                            }, 300);
                        }
                    });

                    // Refresh lightgallery after all animations complete
                    setTimeout(() => {
                        lightGalleryInstance.refresh();
                    }, delay + 200);
                }, 200);
            });
        });
    });
    </script>
    @endpush

    {{--
    Instructions for backend:
    - Replace the demo images array with dynamic images from your database (e.g. $images)
    - Store images in /public/images/gallery or uploads folder
    - You can create an Image model and CRUD for admin upload
    --}}
@endsection