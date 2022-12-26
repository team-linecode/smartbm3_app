@extends('layouts.manage', ['title' => 'Dashboard'])

@section('content')

    @include('component.form-error')

    @can('dashboard student')
        @include('manage.dashboard.student-dashboard')
    @endcan
@stop

@push('include-script')
    @include('component.jquery')
@endpush
