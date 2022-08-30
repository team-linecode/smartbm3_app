@extends('layouts.manage', ['title' => 'Laporan Keuangan'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-center text-uppercase mb-0 d-inline">Laporan Transaksi</h4>
        </div>
        <div class="card-body">
            <form method="get" class="mb-5">
                <div class="row g-3">
                    <div class="col-xxl-3 col-sm-3">
                        <label for="date">Jarak Tanggal</label>
                        <input type="text" class="form-control bg-light border-light @error('date') is-invalid @enderror"
                            name="date" id="date" data-provider="flatpickr" data-date-format="d M, Y"
                            data-range-date="true" placeholder="-- Tentukan Jarak Tanggal --"
                            value="{{ request()->date ?? '' }}">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end col-->

                    <div class="col-xxl-3 col-sm-3">
                        <label for="status">Status</label>
                        <div class="input-light">
                            <select class="form-control" data-choices data-choices-search-false data-choices
                                data-choices-sorting-false name="status" id="status">
                                <option value="all" selected>All</option>
                                <option value="Paid" {{ request()->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Unpaid" {{ request()->status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="Pending" {{ request()->status == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Refund" {{ request()->status == 'Refund' ? 'selected' : '' }}>Refund</option>
                                <option value="Cancel" {{ request()->status == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end col-->

                    <div class="col-xxl-3 col-sm-3">
                        <label for="time">Status</label>
                        <div class="input-light">
                            <select class="form-control" data-choices data-choices-search-false data-choices
                                data-choices-sorting-false name="time" id="time">
                                <option value="Latest" selected>Terbaru</option>
                                <option value="Longest" {{ request()->time == 'Longest' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                        @error('time')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end col-->

                    <div class="col-xxl-1 col-sm-3">
                        <label for="">&nbsp;</label>
                        <div class="d-flex align-items-center">
                            <div class="w-100 me-1">
                                <button class="btn btn-primary w-100">
                                    <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    Filters
                                </button>
                            </div>
                            <div class="w-100 ms-1">
                                <a href="{{ route('app.finance.report.index', 'transaction') }}"
                                    class="btn btn-danger w-100">
                                    <i class="ri-refresh-line me-1 align-bottom"></i>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Invoice ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trans)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>#{{ $trans->invoice_id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $trans->user->name }}</div>
                                    <small class="text-primary">{{ $trans->user->classroom->alias }}
                                        {{ $trans->user->expertise->alias }}</small>
                                </td>
                                <td>Rp{{ number_format($trans->total) }}</td>
                                <td>{!! $trans->status() !!}</td>
                                <td>{{ strftime('%d %B %Y', strtotime($trans->date)) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.finance.transaction.create_detail', $trans->id) }}"
                                                class="btn btn-sm btn-success">Detail</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
    </div>
@stop
