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
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('app.transaction.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ri-exchange-box-line align-middle"></i> Pilih Pembayaran</h5>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            @foreach ($user->schoolyear->costs as $costIdx => $cost)
                                <div class="col-6 col-lg-6">
                                    <div class="accordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ $costIdx }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $costIdx }}"
                                                    aria-expanded="false" aria-controls="collapse{{ $costIdx }}">
                                                    {{ $cost->name }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $costIdx }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading{{ $costIdx }}">
                                                <div class="accordion-body p-2">
                                                    <div class="row g-3">
                                                        @foreach ($cost->details as $costDetailIdx => $cost_detail)
                                                            {{-- INPUT UNTUK TIPE UJIAN --}}
                                                            @if ($cost_detail->category()->slug == 'ujian')
                                                                <div class="col-12">
                                                                    {{ $cost_detail->semester->alias }}
                                                                    <div class="input-group">
                                                                        <div class="input-group-text">
                                                                            <input class="form-check-input mt-0"
                                                                                type="checkbox"
                                                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->id }}][cost_detail_id]"
                                                                                value="{{ $cost_detail->id }}">
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm currency amount"
                                                                            name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->id }}][amount]"
                                                                            placeholder="Jumlah Bayar"
                                                                            value="{{ number_format($cost_detail->amount) }}"
                                                                            disabled required>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            {{-- INPUT UNTUK TIPE SPP --}}
                                                            @if ($cost_detail->category()->slug == 'spp')
                                                                <div class="col-12">
                                                                    <div class="card border-1 shadow-none mb-0">
                                                                        <div class="card-header py-2">
                                                                            <h6 class="mb-0">Kelas
                                                                                {{ $cost_detail->classroom->alias }}</h6>
                                                                        </div>
                                                                        <div class="card-body p-2">
                                                                            <div class="row g-3">
                                                                                @php
                                                                                    $range = range(7, 12);
                                                                                    $range2 = range(1, 6);
                                                                                @endphp
                                                                                @foreach ($range as $month)
                                                                                    <div class="col-12 col-lg-6">
                                                                                        {{ monthId($month) }}
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-text">
                                                                                                <input
                                                                                                    class="form-check-input mt-0"
                                                                                                    type="checkbox"
                                                                                                    name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][{{ $month }}][cost_detail_id]"
                                                                                                    value="{{ $cost_detail->id }}">
                                                                                            </div>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm currency amount"
                                                                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][{{ $month }}][amount]"
                                                                                                placeholder="Jumlah Bayar"
                                                                                                value="{{ number_format($cost_detail->amount) }}"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                @foreach ($range2 as $month2)
                                                                                    <div class="col-12 col-lg-6">
                                                                                        {{ monthId($month2) }}
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-text">
                                                                                                <input
                                                                                                    class="form-check-input mt-0"
                                                                                                    type="checkbox"
                                                                                                    name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][{{ $month2 }}][cost_detail_id]"
                                                                                                    value="{{ $cost_detail->id }}">
                                                                                            </div>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm currency amount"
                                                                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][{{ $month2 }}][amount]"
                                                                                                placeholder="Jumlah Bayar"
                                                                                                value="{{ number_format($cost_detail->amount) }}"
                                                                                                disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            {{-- INPUT UNTUK TIPE DAFTAR ULANG --}}
                                                            @if ($cost_detail->category()->slug == 'daftar-ulang')
                                                                <div class="col-12">
                                                                    Kelas {{ $cost_detail->classroom->alias }}
                                                                    <div class="input-group">
                                                                        <div class="input-group-text">
                                                                            <input class="form-check-input mt-0"
                                                                                type="checkbox"
                                                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][cost_detail_id]"
                                                                                value="{{ $cost_detail->id }}">
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm currency amount"
                                                                            name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][amount]"
                                                                            placeholder="Jumlah Bayar"
                                                                            value="{{ number_format($cost_detail->amount) }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            {{-- INPUT UNTUK TIPE GEDUNG --}}
                                                            @if ($cost_detail->category()->slug == 'gedung' && $cost_detail->group_id == $user->group_id)
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <div class="input-group-text">
                                                                            <input class="form-check-input mt-0"
                                                                                type="checkbox"
                                                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->group_id }}][cost_detail_id]"
                                                                                value="{{ $cost_detail->id }}">
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm currency amount"
                                                                            name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->group_id }}][amount]"
                                                                            placeholder="Jumlah Bayar"
                                                                            value="{{ number_format($cost_detail->amount) }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            {{-- INPUT UNTUK TIPE LAIN-LAIN --}}
                                                            @if ($cost_detail->category()->slug == 'lain-lain')
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <div class="input-group-text">
                                                                            <input class="form-check-input mt-0"
                                                                                type="checkbox"
                                                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->id }}][cost_detail_id]"
                                                                                value="{{ $cost_detail->id }}">
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm currency amount"
                                                                            name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->id }}][amount]"
                                                                            placeholder="Jumlah Bayar"
                                                                            value="{{ number_format($cost_detail->amount) }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-end mt-4">
                            <button class="btn btn-primary align-middle">Tambahkan <i
                                    class="ri-add-line align-middle"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            @include('manage.student_transaction.component.detail')
        </div>
    </div>
@stop

@push('include-script')
    @include('component.loading')

    <script>
        $('.form-check-input').click(function() {
            let amountInput = $(this).parent().next()
            amountInput.prop('disabled', function(i, v) {
                return !v;
            });
        })
    </script>
@endpush
