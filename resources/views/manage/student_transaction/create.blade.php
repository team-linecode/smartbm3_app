@extends('layouts.manage', ['title' => 'Pembayaran'])

@section('content')
    <div class="row @if ($items->count() == 0) justify-content-center @endif">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ri-exchange-box-line align-middle"></i> Pilih Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($user->schoolyear->costs as $costIdx => $cost)
                            <div class="col-12 col-lg-6">
                                <a href="{{ route('app.transaction.create.step2', $cost->slug) }}"
                                    class="btn btn-light border w-100" type="button">
                                    <div class="d-flex justify-content-between">
                                        <div>{{ $cost->name }}</div>
                                        <div><i class="ri ri-arrow-right-line"></i></div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if ($items->count() > 0)
            <div class="col-lg-4">
                @include('manage.student_transaction.component.detail')
            </div>
        @endif
    </div>
@stop
