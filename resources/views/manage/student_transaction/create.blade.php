@extends('layouts.manage', ['title' => 'Pembayaran'])

@section('content')
    <div class="row @if ($items->count() == 0) justify-content-center @endif">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="row align-items-center justify-content-center g-0">
                    <div class="col-5 col-md-3">
                        <img src="{{ Storage::url('background/think.jpg') }}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="text-danger fw-bold">Masih ada biaya yang belum dibayar nih!</h4>
                            <p class="card-text">Ayo cek sisa pembayaran dengan menekan tombol dibawah ini ya.</p>
                            <a href="#" class="btn btn-primary">Cek Tagihan <i
                                    class="ri ri-arrow-right-line align-middle"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ri-exchange-box-line align-middle"></i> Pilih Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($user->schoolyear->costs as $costIdx => $cost)
                            <div class="col-12 col-lg-6">
                                <a href="{{ route('app.transaction.create.step2', $cost->slug . (request()->get('uuid') ? '?uuid=' . request()->get('uuid') : '')) }}"
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
