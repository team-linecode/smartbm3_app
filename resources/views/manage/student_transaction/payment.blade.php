@extends('layouts.manage', ['title' => 'Riwayat Pembayaran'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ri-file-list-line align-middle"></i> Rincian Pembayaran</h5>
                </div>
                <div class="card-body">
                    @php($total = 0)
                    @foreach ($items as $item)
                        @if ($item->cost_detail->category()->slug == 'ujian')
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="fw-semibold text-uppercase">{{ $item->cost_detail->cost->name }} |
                                    {{ $item->cost_detail->semester->alias }}</div>
                                <div>Rp{{ number_format($item->cost_detail->amount, '0', '.', '.') }}</div>
                            </div>
                        @endif

                        @if ($item->cost_detail->category()->slug == 'spp')
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="fw-semibold text-uppercase">{{ $item->cost_detail->cost->cost_category->name }} |
                                    {{ strftime('%B %Y', strtotime($item->month)) }}</div>
                                <div>Rp{{ number_format($item->cost_detail->amount, '0', '.', '.') }}</div>
                            </div>
                        @endif

                        @php($total += $item->cost_detail->amount)
                    @endforeach

                    <hr>

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-semibold text-uppercase">TOTAL</div>
                        <div>Rp{{ number_format($total, '0', '.', '.') }}</div>
                    </div>

                    <button class="btn btn-primary w-100 mt-3">Pilih Metode Pembayaran</button>
                </div>
            </div>
        </div>
    </div>
@stop
