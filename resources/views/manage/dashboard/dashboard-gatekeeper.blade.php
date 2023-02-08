@extends('layouts.manage', ['title' => 'Dashboard'])

@section('content')

    @include('component.form-error')

    <div class="row">
        <div class="col-6">
            <a href="{{ route('app.absent.create') }}">
                <div class="card card-hover">
                    <div class="card-body text-center">
                        <div class="display-1">
                            <i class="ri-run-line"></i>
                        </div>
                        <h5>Absen Terlambat <i class="align-middle ri-arrow-right-s-line"></i></h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6">
            <a href="{{ route('app.absent.index') }}">
                <div class="card card-hover">
                    <div class="card-body text-center">
                        <div class="display-1">
                            <i class="ri-file-list-3-line"></i>
                        </div>
                        <h5>Absen Terlambat <i class="align-middle ri-arrow-right-s-line"></i></h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
@stop

@push('include-script')
    @include('component.jquery')
@endpush
