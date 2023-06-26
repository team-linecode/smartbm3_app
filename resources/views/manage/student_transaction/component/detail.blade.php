<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="ri-file-list-line align-middle"></i> Rincian Pembayaran</h5>
    </div>
    <div class="card-body">
        @php($total = 0)
        @forelse ($items as $item)
            <div class="d-flex align-items-center justify-content-between mb-2">
                @if ($item->cost_detail->category()->slug == 'ujian')
                    <div class="w-50 fw-semibold text-uppercase">{{ $item->cost_detail->cost->name }} |
                        {{ $item->cost_detail->semester->alias }}</div>
                    <div class="w-50 text-end px-2">
                        Rp{{ number_format($item->amount, '0', '.', '.') }}</div>
                @endif

                @if ($item->cost_detail->category()->slug == 'spp')
                    <div class="w-50 fw-semibold text-uppercase">
                        {{ $item->cost_detail->cost->cost_category->name }} |
                        {{ strftime('%B %Y', strtotime($item->month)) }}</div>
                    <div class="w-50 text-end px-2">
                        Rp{{ number_format($item->amount, '0', '.', '.') }}</div>
                @endif

                @if ($item->cost_detail->category()->slug == 'daftar-ulang')
                    <div class="w-50 fw-semibold text-uppercase">
                        {{ $item->cost_detail->cost->cost_category->name }} |
                        {{ $item->cost_detail->classroom->name }}</div>
                    <div class="w-50 text-end px-2">
                        Rp{{ number_format($item->amount, '0', '.', '.') }}</div>
                @endif

                @if ($item->cost_detail->category()->slug == 'gedung')
                    <div class="w-50 fw-semibold text-uppercase">
                        {{ $item->cost_detail->cost->cost_category->name }}</div>
                    <div class="w-50 text-end px-2">
                        Rp{{ number_format($item->amount, '0', '.', '.') }}</div>
                @endif

                @if ($item->cost_detail->category()->slug == 'lain-lain')
                    <div class="w-50 fw-semibold text-uppercase">
                        {{ $item->cost_detail->cost->name }}</div>
                    <div class="w-50 text-end px-2">
                        Rp{{ number_format($item->amount, '0', '.', '.') }}</div>
                @endif

                <div>
                    <form action="{{ route('app.transaction.delete_item', $item->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-danger btn-sm rounded-pill c-delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                </div>

            </div>

            @php($total += $item->amount)
        @empty
            <div class="alert alert-warning">Silahkan tambahkan pembayaran</div>
        @endforelse

        <hr>

        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="fw-semibold text-uppercase">TOTAL</div>
            <div>Rp{{ number_format($total, '0', '.', '.') }}</div>
        </div>

        @if ($items->isEmpty())
            <button class="btn btn-primary w-100 mt-3 disabled">Pilih Metode Pembayaran</button>
        @else
            <form action="{{ route('app.transaction.payment') }}" method="post">
                @csrf
                @method('post')
                <button class="btn btn-primary w-100 mt-3 c-payment">Pilih Metode Pembayaran</button>
            </form>
        @endif
    </div>
</div>
