@extends('layouts.app-admin')
@section('content')
    @include('components.admin.impact-stories.list')
    @include('components.admin.impact-stories.create')
    @include('components.admin.impact-stories.update')
    @include('components.admin.impact-stories.delete')
@endsection
