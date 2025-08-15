@extends('layouts.app-admin')
@section('content')
    @include('components.admin.attendances.list')
    @include('components.admin.attendances.bulk-delete')
@endsection
