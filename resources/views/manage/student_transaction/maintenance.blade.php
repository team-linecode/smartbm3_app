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
                    <h4 class="text-warning fw-bold">Mohon Maaf Atas Ketidaknyamanannya!</h4>
                    <div class="mb-3">
                        <img src="{{ Storage::url('background/maintenance.jpg') }}" width="300">
                    </div>
                    <h5 class="mb-3">Saat ini sistem transaksi sedang dalam perbaikan, <br>Silahkan lakukan beberapa saat lagi.</h5>
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <a href="{{ route('app.transaction.create') }}" class="btn btn-danger w-100">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
