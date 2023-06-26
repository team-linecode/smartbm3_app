@extends('layouts.manage', ['title' => 'Pembayaran'])

@push('include-style')
    <style>
        .hover-card:hover {
            background-color: rgba(0, 0, 0, 0.03);
            transition: 0.3s;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="text-success fw-bold">Pembayaran Telah Disimpan!</h4>
                    <div class="mb-3">
                        <img src="{{ Storage::url('background/success_saved.jpg') }}" width="300">
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <a href="{{ route('app.transaction.create') }}" class="btn btn-outline-primary w-100">Mau Pilih Pembayaran Lagi?</a>
                            <div class="my-2">Atau</div>
                            <a href="{{ route('app.transaction.detail') }}" class="btn btn-primary w-100">Langsung Bayar Aja</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
