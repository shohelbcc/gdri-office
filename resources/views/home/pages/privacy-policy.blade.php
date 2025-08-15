@extends('layouts.app-home')
@section('content')
    <!-- District Coverage Start -->
    <div id="privacyPolicy" class="py-5">
        <div class="container">
            <div class="row text-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="col-md-12">
                    <h2 class="section_title_light">Our {{ $mainContent->name }}</h2>
                </div>
            </div>
            <div class="row wow fadeInUp" data-wow-delay="0.1s">
                <div class="col-md-12">
                    <p>{!! $mainContent->content !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection