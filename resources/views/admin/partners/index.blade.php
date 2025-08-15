@extends('layouts.app-admin')
@section('content')
    @include('components.admin.partners.list')
    @include('components.admin.partners.create')
    @include('components.admin.partners.update')
    @include('components.admin.partners.delete')
@endsection
