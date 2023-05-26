@extends('layouts.manage', ['title' => 'Transaksi'])

@section('content')
    <form action="{{ route('app.finance.transaction.store') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-body bg-light py-3">
                <h5 class="mb-0">Data Siswa</h5>
            </div>
            <div class="card-body border-bottom border-bottom-0 p-4">
                <div class="row gy-3">
                    <div class="col-lg-8 order-1 order-md-0 order-lg-0">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label">Nama Siswa</label>
                            </div>
                            <div class="col-lg-9">
                                <p id="displayName">{{ $user->name ?? '___' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label">NIS/NISN</label>
                            </div>
                            <div class="col-lg-9">
                                <p id="displayNis">{{ $user->nisn ?? '___' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label">Kelas</label>
                            </div>
                            <div class="col-lg-9">
                                <p id="displayClass">
                                    {{ isset($user) ? $user->myClass() . ' ' . $user->expertise->name : '___' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label mb-0">Tahun Ajaran</label>
                            </div>
                            <div class="col-lg-9">
                                <p class="mb-0" id="displaySchoolyear">{{ $user->schoolyear->name ?? '___' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">Pilih Nama Siswa</label>
                        <select name="user" class="form-select select2 w-100" id="user">
                            <option value="">- Pilih Siswa/i -</option>
                            @foreach ($users as $usr)
                                <option value="{{ $usr->username }}"
                                    {{ select_old($usr->username, old('user'), true, isset($user) ? $user->username : '') }}>
                                    {{ $usr->name }} [{{ $usr->myClass() }} {{ $usr->expertise->name }}]
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            @isset($user)
                <div class="card-body bg-light py-3">
                    <h5 class="mb-0">Item Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach ($user->schoolyear->costs as $costIdx => $cost)
                            <div class="col-lg-4">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $costIdx }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $costIdx }}" aria-expanded="false"
                                                aria-controls="collapse{{ $costIdx }}">
                                                {{ $cost->name }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $costIdx }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $costIdx }}">
                                            <div class="accordion-body">
                                                <div class="row g-3">
                                                    @foreach ($cost->details as $costDetailIdx => $cost_detail)
                                                        {{-- INPUT UNTUK TIPE UJIAN --}}
                                                        @if ($cost_detail->category()->slug == 'ujian')
                                                            <div class="col-12">
                                                                {{ $cost_detail->semester->alias }}
                                                                <div class="input-group">
                                                                    <div class="input-group-text">
                                                                        <input class="form-check-input mt-0" type="checkbox"
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
                                                                    <div class="card-body">
                                                                        <div class="row g-3">
                                                                            @php
                                                                                if ($cost_detail->classroom->alias == '10') {
                                                                                    $range = range(7, 12);
                                                                                } else {
                                                                                    $range = range(1, 12);
                                                                                }
                                                                            @endphp
                                                                            @foreach ($range as $month)
                                                                                <div class="col-12">
                                                                                    {{ monthId($month) }}
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">
                                                                                            <input class="form-check-input mt-0"
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
                                                                        <input class="form-check-input mt-0" type="checkbox"
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
                                                                        <input class="form-check-input mt-0" type="checkbox"
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
                                                                        <input class="form-check-input mt-0" type="checkbox"
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
                </div>

                <div class="card-body bg-light py-3">
                    <h5 class="mb-0">Keterangan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="note" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note" rows="5"
                                placeholder="Keterangan (isi jika diperlukan)">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status"
                                    id="stat">
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="Paid" {{ select_old('Paid', old('status')) }}>Lunas</option>
                                    <option value="Unpaid" {{ select_old('Unpaid', old('status')) }}>Belum Lunas</option>
                                    <option value="Pending" {{ select_old('Pending', old('status')) }}>Menunggu Pembayaran
                                    </option>
                                    <option value="Refund" {{ select_old('Refund', old('status')) }}>Pengembalian Dana
                                    </option>
                                    <option value="Cancel" {{ select_old('Cancel', old('status')) }}>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" id="date" value="{{ date('Y-m-d') ?? old('date') }}">
                                    @error('date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="paymentMethod" class="form-label">Metode Transaksi</label>
                                <div class="input-light">
                                    <select class="form-control @error('payment_method') is-invalid @enderror"
                                        name="payment_method" id="paymentMethod">
                                        <option value="">Metode Pembayaran</option>
                                        @foreach ($payment_methods as $payment_method)
                                            <option value="{{ $payment_method->id }}"
                                                {{ select_old($payment_method->id, old('payment_method')) }}>
                                                {{ $payment_method->account }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('payment_method')
                                    <div class="small text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input class="form-control bg-light border-0" type="text" id="cardNumber"
                                    placeholder="Nomer Rekening" value="{{ $trans->payment_method->account_number ?? '-' }}"
                                    disabled>
                            </div>

                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </form>
@stop

@push('include-script')
    @include('component.loading')

    <script>
        $('#user').change(function() {
            let username = $(this).val()
            showLoading();
            window.location.href = "{{ route('app.finance.transaction.create_detail', ':username') }}".replace(
                ':username', username);
        })

        $('.form-check-input').click(function() {
            let amountInput = $(this).parent().next()
            amountInput.prop('disabled', function(i, v) {
                return !v;
            });
        })

        $('#paymentMethod').change(function() {
            getAccountNumber("{{ route('app.finance.transaction.get_account_number') }}", {
                _token: "{{ csrf_token() }}",
                payment_method_id: $(this).val(),
            })
        })
    </script>
@endpush
