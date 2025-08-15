@extends('layouts.app-admin')
@section('content')
    @include('components.admin.experience-certificates.list')
    @include('components.admin.experience-certificates.create')
    @include('components.admin.experience-certificates.update')
    @include('components.admin.experience-certificates.delete')
@endsection
