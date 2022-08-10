@extends('layouts.manage', ['title' => 'Transaksi'])

@push('include-style')
    <!-- choices -->
    <link rel="stylesheet" href="/vendor/manage/assets/libs/choices.js/public/assets/styles/choices.min.css">
    <!-- flatpickr -->
    <link rel="stylesheet" href="/vendor/manage/assets/libs/flatpickr/flatpickr.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-body border-bottom border-bottom-dashed p-4">
            @include('component.default-alert')

            <div class="row gy-3">
                <div class="col-lg-8 order-1 order-md-0 order-lg-0">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label">Nama Siswa</label>
                        </div>
                        <div class="col-lg-9">
                            <p id="displayName">{{ $trans->user->name }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label">NIS/NISN</label>
                        </div>
                        <div class="col-lg-9">
                            <p id="displayNis">{{ !is_null($trans->user->nisn) ? $trans->user->nisn : '___' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label">Kelas</label>
                        </div>
                        <div class="col-lg-9">
                            <p id="displayClass">{{ $trans->user->classroom->alias }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label mb-0">Jurusan</label>
                        </div>
                        <div class="col-lg-9">
                            <p id="displayExpertise">{{ $trans->user->expertise->alias }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label mb-0">Tahun Ajaran</label>
                        </div>
                        <div class="col-lg-9">
                            <p id="displaySchoolyear">{{ $trans->user->schoolyear->name }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label mb-0">Gelombang</label>
                        </div>
                        <div class="col-lg-9">
                            <p class="mb-0" id="displaySchoolyear">({{ $trans->user->group->number }})</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSPP"><i
                            class="ri-table-2 align-middle"></i> Tabel SPP</a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-lg-2 col-sm-6">
                    <label for="invoicenoInput">Invoice ID</label>
                    <input type="text" class="form-control bg-light border-0" id="" placeholder="Invoice No"
                        value="#{{ $trans->invoice_id }}" readonly="readonly" />
                </div>
                <!--end col-->
                <div class="col-lg-3 col-sm-6">
                    <div>
                        <label for="date-field">Tanggal Transaksi</label>
                        <input type="text" class="form-control bg-light border-0" name="transaction_date" id="date-field"
                            data-provider="flatpickr" data-time="true" data-date-format="Y-m-d" data-enable-time
                            placeholder="Pilih Tanggal" data-default-date="{{ $trans->date }}" form="transaction">
                        @error('transaction_date')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!--end col-->
                <div class="col-lg-4 col-sm-6">
                    <label for="choices-payment-status">Status Pembayaran</label>
                    <div class="input-light">
                        <select class="form-control bg-light border-0" name="status" data-choices data-choices-search-false
                            data-choices-sorting-false id="choices-payment-status" form="transaction">
                            <option value="">Pilih Status</option>
                            <option value="Paid" {{ select_old('Paid', old('status'), true, $trans->status) }}>Lunas
                            </option>
                            <option value="Unpaid" {{ select_old('Unpaid', old('status'), true, $trans->status) }}>Belum
                                Lunas
                            </option>
                            <option value="Pending" {{ select_old('Pending', old('status'), true, $trans->status) }}>
                                Menunggu&nbsp;Pembayaran
                            </option>
                            <option value="Refund" {{ select_old('Refund', old('status'), true, $trans->status) }}>
                                Dikembalikan
                            </option>
                            <option value="Cancel" {{ select_old('Cancel', old('status'), true, $trans->status) }}>
                                Dibatalkan
                            </option>
                        </select>
                    </div>
                    @error('status')
                        <div class="small text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <!--end col-->
                <div class="col-lg-3 col-sm-6">
                    <div>
                        <label for="totalamountInput">Total Transaksi</label>
                        <input type="text" class="form-control bg-light border-0" id="totalamountInput"
                            placeholder="Rp. {{ number_format($trans->total) }}" readonly />
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">

                <table class="invoice-table table table-borderless table-nowrap">
                    <thead class="align-middle">
                        <tr class="table-active">
                            <th scope="col">Transaksi</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <form action="{{ route('app.finance.transaction.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $trans->id }}">
                        <tbody>
                            <tr>
                                <td class="text-start">
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-4 col-lg-4">
                                                <label>Biaya</label>
                                                <select type="text"
                                                    class="form-control bg-light border-0 @error('cost_id') is-invalid @enderror"
                                                    name="cost_id" id="selectCost">
                                                    <option value="" hidden>- Pilih Biaya -</option>
                                                    @foreach ($trans->user->schoolyear->costs as $cost)
                                                        <option value="{{ $cost->id }}">{{ $cost->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('cost_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-4 col-lg-4">
                                                <label>Detail</label>
                                                <select type="text"
                                                    class="form-control bg-light border-0 @error('cost_detail_id') is-invalid @enderror"
                                                    name="cost_detail_id" id="selectCostDetail" disabled></select>
                                                @error('cost_detail_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-4 col-lg-4">
                                                <label>Tanggal</label>
                                                <input type="text"
                                                    class="form-control bg-light border-0 @error('date') is-invalid @enderror"
                                                    name="date" id="date-field" data-provider="flatpickr"
                                                    data-date-format="Y-m-d" placeholder="Pilih Tanggal">
                                                @error('date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <label>Jumlah (Rp)</label>
                                    <input type="text"
                                        class="form-control bg-light currency border-0 @error('amount') is-invalid @enderror"
                                        name="amount" id="amount" placeholder="Rp0" disabled />
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <label class="d-block">&nbsp;</label>
                                    <button class="btn btn-primary mb-2 w-100">Simpan</button>
                                </td>
                            </tr>
                        </tbody>
                    </form>
                </table>
                <!--end table-->
            </div>

            {{-- table --}}
            <div class="table-responsive table-card">
                <table class="table table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Biaya</th>
                            <th scope="col">Detail</th>
                            <th scope="col">Bulan</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @forelse ($trans->details->sortBy('cost_detail_id') as $trx_detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trx_detail->cost_detail->cost->name }}</td>
                                <td>{{ $trx_detail->cost_detail_by_category($trx_detail->cost_detail->id, $trx_detail->cost_detail->cost->id) }}
                                </td>
                                <td>{{ $trx_detail->date ? strftime('%B %Y', strtotime($trx_detail->date)) : '-' }}
                                </td>
                                <td>Rp. {{ number_format($trx_detail->amount) }}</td>
                                <td class="text-end">
                                    <form action="{{ route('app.finance.transaction.detail.destroy', $trx_detail->id) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger c-delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php($total += $trx_detail->amount)
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <h6 class="text-danger mb-0">Tidak ada data</h6>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total</td>
                            <td colspan="2">Rp. {{ number_format($total) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{-- end table --}}

            <div class="row justify-content-end mt-3">
                <div class="col-lg-8">
                    <label for="exampleFormControlTextarea1" class="form-label text-uppercase fw-semibold">CATATAN</label>
                    <textarea class="form-control alert alert-primary" name="note" id="exampleFormControlTextarea1"
                        placeholder="Tambahkan catatan disini" rows="3" form="transaction">{{ old('note') ?? $trans->note }}</textarea>
                </div>
                <div class="col-lg-4">
                    <div class="mb-2">
                        <label for="choices-payment-type" class="form-label text-uppercase fw-semibold">Payment
                            Details</label>
                        <div class="input-light">
                            <select class="form-control bg-light border-0" data-choices data-choices-search-false
                                name="payment_method_id" id="paymentMethod" form="transaction">
                                <option value="">Metode Pembayaran</option>
                                @foreach ($payment_methods as $payment_method)
                                    <option value="{{ $payment_method->id }}"
                                        @if ($trans->payment_method_id == null) {{ select_old($payment_method->id, old('payment_method_id')) }}
                                        @else
                                        {{ select_old($payment_method->id, old('payment_method_id'), true, $trans->payment_method_id) }} @endif>
                                        {{ $payment_method->account }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('payment_method_id')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <input class="form-control bg-light border-0" type="text" id="cardNumber"
                            placeholder="Nomer Rekening" value="{{ $trans->payment_method->account_number ?? '-' }}"
                            disabled>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                <form action="{{ route('app.finance.transaction.update_transaction', $trans->id) }}" method="POST"
                    id="transaction">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i>
                </form>
                Save</button>
                @if ($trans->details()->exists())
                    <a href="{{ route('app.finance.transaction.print', $trans->id) }}" target="_blank"
                        class="btn btn-primary"><i class="ri-printer-line align-bottom me-1"></i> Cetak Invoice</a>
                @else
                    <a href="javascript:void(0)" class="btn btn-primary disabled"><i
                            class="ri-printer-line align-bottom me-1"></i> Cetak Invoice</a>
                @endif
                <a href="javascript:void(0);" class="btn btn-danger"><i class="ri-send-plane-fill align-bottom me-1"></i>
                    Send Invoice</a>
            </div>
        </div>
    </div>

    <div id="modalSPP" class="modal fade" tabindex="-1" aria-labelledby="modalSPPLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSPPLabel">Tabel SPP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                @foreach ($cost_spp->details as $cost_detail)
                                    <tr>
                                        <th class="table-light align-middle">
                                            Kelas&nbsp;{{ $cost_detail->classroom->alias }}</th>
                                        @if ($cost_detail->classroom->alias == '10')
                                            @foreach (dateRange($trans->user->schoolyear->getYears(0), $trans->user->schoolyear->getYears(1)) as $ta_1)
                                                <td class="py-5 {!! $cost_detail->markTransactionExists($trans->user->id, $ta_1, 'bg-soft-success text-success') !!}">
                                                    {{ strftime('%B %Y', strtotime($ta_1)) }}</td>
                                            @endforeach
                                        @endif

                                        @if ($cost_detail->classroom->alias == '11')
                                            @foreach (dateRange($trans->user->schoolyear->getYears(1), $trans->user->schoolyear->getYears(2)) as $ta_2)
                                                <td class="py-5 {!! $cost_detail->markTransactionExists($trans->user->id, $ta_2, 'bg-soft-success text-success') !!}">
                                                    {{ strftime('%B %Y', strtotime($ta_2)) }}</td>
                                            @endforeach
                                        @endif

                                        @if ($cost_detail->classroom->alias == '12')
                                            @foreach (dateRange($trans->user->schoolyear->getYears(2), $trans->user->schoolyear->getYears(3)) as $ta_3)
                                                <td class="py-5 {!! $cost_detail->markTransactionExists($trans->user->id, $ta_3, 'bg-soft-success text-success') !!}">
                                                    {{ strftime('%B %Y', strtotime($ta_3)) }}</td>
                                            @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@push('include-script')
    @include('component.loading')

    <!-- choices -->
    <script src="/vendor/manage/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- flatpickr -->
    <script src="/vendor/manage/assets/libs/flatpickr/flatpickr.min.js"></script>
    <!-- cleave.js -->
    <script src="/vendor/manage/assets/libs/cleave.js/cleave.min.js"></script>
    <!--Invoice create init js-->
    <script src="/vendor/manage/assets/js/pages/invoicecreate.init.js"></script>

    <script>
        $('#selectCost').change(function() {
            getCostDetail("{{ route('app.finance.transaction.get_cost_detail') }}", {
                _token: "{{ csrf_token() }}",
                cost_id: $(this).val(),
                user_id: "{{ $trans->user->id }}"
            })
        })

        $('#selectCostDetail').change(function() {
            getCostAmount("{{ route('app.finance.transaction.get_cost_amount') }}", {
                _token: "{{ csrf_token() }}",
                cost_detail_id: $(this).val(),
            })
        })

        $('#paymentMethod').change(function() {
            getAccountNumber("{{ route('app.finance.transaction.get_account_number') }}", {
                _token: "{{ csrf_token() }}",
                payment_method_id: $(this).val(),
            })
        })
    </script>
@endpush
