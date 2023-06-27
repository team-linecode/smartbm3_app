@extends('layouts.manage', ['title' => 'Pembayaran'])
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ri-exchange-box-line align-middle"></i> Pilih Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.transaction.store') }}" method="post">
                        @csrf
                        <a href="{{ route('app.transaction.create') }}" class="btn btn-danger mb-3"><i
                                class="ri ri-arrow-left-line align-middle"></i> Kembali</a>

                        <div class="row g-3">
                            @forelse ($cost->details->whereIn($where['key'] ?? '', $where['value'] ?? '') as $cost_detail)
                                {{-- INPUT UNTUK TIPE UJIAN --}}
                                @if ($cost_detail->category()->slug == 'ujian')
                                    <div class="col-12">
                                        <h6>{{ $cost_detail->semester->alias }}</h6>
                                        <div class="input-group">
                                            <div class="input-group-text p-1">
                                                <input class="form-check-input form-check-readonly mt-0"
                                                    style="width: 1.9rem; height: 100%;" type="checkbox"
                                                    name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->id }}][cost_detail_id]"
                                                    value="{{ $cost_detail->id }}"
                                                    {{ auth()->user()->transaction_history($cost_detail->id)['is_paid']? 'disabled checked': '' }}>
                                            </div>
                                            <input type="text" class="form-control currency amount"
                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->id }}][amount]"
                                                placeholder="Jumlah Bayar"
                                                value="{{ number_format(auth()->user()->transaction_history($cost_detail->id)['remaining']) }}"
                                                disabled required>
                                        </div>
                                    </div>
                                @endif

                                {{-- INPUT UNTUK TIPE SPP --}}
                                @if ($cost_detail->category()->slug == 'spp')
                                    <div class="col-12">
                                        <div class="card border-1 shadow-none mb-0">
                                            <div class="card-header bg-primary">
                                                <h6 class="mb-0 text-white">Biaya Kelas
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
                                                            <h6>{{ monthId($month) }}
                                                                {{ auth()->user()->schoolyearsForSPP('a', $cost_detail->classroom->alias) }}
                                                            </h6>
                                                            <div class="input-group">
                                                                <div class="input-group-text p-1">
                                                                    <input class="form-check-input form-check-readonly mt-0"
                                                                        style="width: 1.9rem; height: 100%;" type="checkbox"
                                                                        name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][{{ $month }}][cost_detail_id]"
                                                                        value="{{ $cost_detail->id }}">
                                                                </div>
                                                                <input type="text" class="form-control currency amount"
                                                                    name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][{{ $month }}][amount]"
                                                                    placeholder="Jumlah Bayar"
                                                                    value="{{ number_format($cost_detail->amount) }}"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @foreach ($range2 as $month2)
                                                        <div class="col-12 col-lg-6">
                                                            <h6>{{ monthId($month2) }}
                                                                {{ auth()->user()->schoolyearsForSPP('b', $cost_detail->classroom->alias) }}
                                                            </h6>
                                                            <div class="input-group">
                                                                <div class="input-group-text p-1">
                                                                    <input class="form-check-input form-check-readonly mt-0"
                                                                        style="width: 1.9rem; height: 100%;" type="checkbox"
                                                                        name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][{{ $month2 }}][cost_detail_id]"
                                                                        value="{{ $cost_detail->id }}">
                                                                </div>
                                                                <input type="text" class="form-control currency amount"
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
                                        <h6>Daftar ulang kelas {{ $cost_detail->classroom->alias }}</h6>
                                        <div class="input-group">
                                            <div class="input-group-text p-1">
                                                <input class="form-check-input form-check-cost mt-0"
                                                    style="width: 1.9rem; height: 100%;" type="checkbox"
                                                    name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][cost_detail_id]"
                                                    value="{{ $cost_detail->id }}">
                                            </div>
                                            <input type="text" class="form-control currency amount"
                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->classroom_id }}][amount]"
                                                placeholder="Jumlah Bayar"
                                                value="{{ number_format(auth()->user()->transaction_history($cost_detail->id)['remaining']) }}"
                                                disabled>
                                        </div>
                                        @include('manage.student_transaction.component.percentages')
                                    </div>
                                @endif

                                {{-- INPUT UNTUK TIPE GEDUNG --}}
                                @if ($cost_detail->category()->slug == 'gedung' && $cost_detail->group_id == $user->group_id)
                                    <div class="col-12">
                                        <h6>{{ $cost_detail->cost->name }}</h6>
                                        <div class="input-group">
                                            <div class="input-group-text p-1">
                                                <input class="form-check-input form-check-cost mt-0"
                                                    style="width: 1.9rem; height: 100%;" type="checkbox"
                                                    name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->group_id }}][cost_detail_id]"
                                                    value="{{ $cost_detail->id }}">
                                            </div>
                                            <input type="text" class="form-control currency amount"
                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->group_id }}][amount]"
                                                placeholder="Jumlah Bayar"
                                                value="{{ number_format(auth()->user()->transaction_history($cost_detail->id)['remaining']) }}"
                                                disabled>
                                        </div>
                                        @include('manage.student_transaction.component.percentages')
                                    </div>
                                @endif

                                {{-- INPUT UNTUK TIPE LAIN-LAIN --}}
                                @if ($cost_detail->category()->slug == 'lain-lain')
                                    <div class="col-12">
                                        <h6>{{ $cost_detail->cost->name }}</h6>
                                        <div class="input-group">
                                            <div class="input-group-text p-1">
                                                <input class="form-check-input form-check-cost mt-0"
                                                    style="width: 1.9rem; height: 100%;" type="checkbox"
                                                    name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->id }}][cost_detail_id]"
                                                    value="{{ $cost_detail->id }}">
                                            </div>
                                            <input type="text" class="form-control currency amount"
                                                name="costs[{{ $cost_detail->category()->slug }}][{{ $cost_detail->id }}][amount]"
                                                placeholder="Jumlah Bayar"
                                                value="{{ number_format(auth()->user()->transaction_history($cost_detail->id)['remaining']) }}"
                                                disabled>
                                        </div>
                                        @include('manage.student_transaction.component.percentages')
                                    </div>
                                @endif
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning fw-bold text-center mb-0">
                                        Tidak Ada Biaya
                                    </div>
                                </div>
                            @endforelse

                            @if ($cost->details->whereIn($where['key'] ?? '', $where['value'] ?? '')->count() > 0)
                                <div class="mt-5 text-end">
                                    <button class="btn btn-primary">Simpan Pembayaran</button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('include-script')
    @include('component.loading')

    <script>
        $('.form-check-cost').click(function() {
            let amountInput = $(this).parent().next()
            amountInput.prop('disabled', function(i, v) {
                return !v;
            });

            $(this).parent().parent().next().toggleClass('d-none')
        })

        $('.form-check-readonly').click(function() {
            let amountInput = $(this).parent().next();

            if (amountInput.attr('disabled')) {
                amountInput.removeAttr('disabled');
                amountInput.prop('readonly', true);
            } else if (amountInput.prop('readonly')) {
                amountInput.prop('readonly', false);
                amountInput.attr('disabled', 'disabled');
            }
        });


        $('.cost-percentage').click(function() {
            let percentage = $(this).data('percentage') / 100
            let amount = $(this).data('amount') * percentage

            var formatter = new Intl.NumberFormat('en-US', {
                style: 'decimal',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });

            $(this).parent().parent().parent().prev().find('.amount').val(formatter.format(amount)).attr('value', formatter.format(amount))
        })
    </script>
@endpush
