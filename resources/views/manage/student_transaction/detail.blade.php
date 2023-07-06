@extends('layouts.manage', ['title' => 'Pembayaran'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <a href="{{ route('app.transaction.create') }}" class="btn btn-danger mb-3"><i class="ri ri-arrow-left-line align-middle"></i> Kembali</a>
            @include('manage.student_transaction.component.detail')
        </div>
    </div>
@stop
