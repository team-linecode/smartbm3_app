@extends('layouts.manage', ['title' => 'Dashboard'])

@section('content')

    @include('component.form-error')

    {{-- your scripts --}}
@stop

@push('include-script')
    @include('component.jquery')
@endpush
