@extends('layouts.app-admin')
@section('content')
    <div class="container-fluid mt-3 admin_page">
        <div class="row mb-4">
            <div class="col-md-6">
                @include('profile.partials.profile-update')
            </div>
            <div class="col-md-6">
                @include('profile.partials.details')
            </div>
        </div>
    </div>
@endsection

