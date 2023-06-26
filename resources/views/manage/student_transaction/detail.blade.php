@extends('layouts.manage', ['title' => 'Pembayaran'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            @include('manage.student_transaction.component.detail')
        </div>
    </div>
@stop
