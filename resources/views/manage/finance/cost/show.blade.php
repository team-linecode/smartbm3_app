@extends('layouts.manage', ['title' => 'Biaya Sekolah'])

@push('include-style')
@include('component.datatables-style')
@endpush

@section('content')

@include('component.form-error')

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-center">
                <a href="{{ route('app.finance.cost.index') }}" class="btn btn-light me-2"><i class="ri-arrow-left-s-line"></i></a>
                <h4 class="card-title text-center text-uppercase mb-0 d-inline">T.A {{ $schoolyear->name }}</h4>
            </div>
            <div>
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Tambah</button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        @foreach($cost_categories as $cost_category)
                        <li><a class="dropdown-item" href="{{ route('app.finance.cost.create', [$schoolyear->slug, $cost_category->id]) }}">{{ $cost_category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="list-group shadow mb-4">
    @foreach($schoolyear->costs()->orderBy('cost_category_id')->get() as $cost)
    <a href="{{ route('app.finance.cost.detail', [$schoolyear->slug, $cost->slug]) }}" class="list-group-item list-group-item-action">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <i class="ri-file-list-3-line align-middle me-2"></i>{{ $cost->name }}
            </div>
            <div>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>
    </a>
    @endforeach
</div>

@if (!$schoolyear->costs()->exists())
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <img src="{{ Storage::url('svg/no-data.svg') }}" alt="">
        <h5 class="text-center">Upss!! Tidak ada data.</h5>
    </div>
</div>
@endif
@stop

@push('include-script')
@include('component.jquery')
@include('component.datatables-script')
@endpush