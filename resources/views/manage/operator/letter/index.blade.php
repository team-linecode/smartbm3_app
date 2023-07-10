@extends('layouts.manage', ['title' => 'Letter'])

@push('include-style')
@include('component.datatables-style')
@endpush

@section('content')
<div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ri-exchange-box-line align-middle"></i> Pilih Kategori Surat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($letter_categories as $lc)
                            <div class="col-12 col-lg-6">
                                <a href="{{ route('app.letter', $lc->slug) }}"
                                    class="btn btn-light border w-100" type="button">
                                    <div class="d-flex justify-content-between">
                                        <div>{{ $lc->name }}</div>
                                        <div><i class="ri ri-arrow-right-line"></i></div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('include-script')
@include('component.datatables-script')
@endpush