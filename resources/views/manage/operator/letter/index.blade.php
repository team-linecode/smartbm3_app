@extends('layouts.manage', ['title' => 'Letter'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
            <div>
                <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Penyuratan</h4>
            </div>
            <div class="text-center">
                <a href="{{ route('app.letter.create') }}" class="btn btn-primary">Tambah</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <!-- end table -->
        </div>
        <!-- end table responsive -->
    </div>
</div>
@stop

@push('include-script')
    @include('component.datatables-script')
@endpush
