@extends('layouts.app-admin')
@section('content')
    @include('components.admin.district-coverages.list')
    @include('components.admin.district-coverages.create')
    {{-- @include('components.admin.district-coverages.update') --}}
    @include('components.admin.district-coverages.delete')
@endsection
