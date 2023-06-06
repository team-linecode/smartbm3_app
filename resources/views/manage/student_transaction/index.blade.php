@extends('layouts.manage', ['title' => 'Riwayat Pembayaran'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
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
                        @foreach ($transactions as $trans)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>#{{ $trans->invoice_id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $trans->user->name }}</div>
                                    <small class="text-primary">{{ $trans->user->classroom->alias }}
                                        {{ $trans->user->expertise->name }}</small>
                                </td>
                                <td>Rp{{ number_format($trans->total) }}</td>
                                <td>{!! $trans->status() !!}</td>
                                <td>{{ strftime('%d %B %Y | %H:%M', strtotime($trans->date)) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if ($trans->status == 'Pending' || $trans->status == 'Unpaid' && $trans->bill_url != null)
                                            <div class="pay">
                                                <a href="https://{{ $trans->bill_url }}"
                                                    class="btn btn-sm btn-primary">Bayar</a>
                                            </div>
                                        @endif
                                        <div class="edit">
                                            <a href="{{ route('app.finance.transaction.show', $trans->invoice_id) }}"
                                                class="btn btn-sm btn-success">Detail</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
    </div>
@stop

@push('include-script')
    @include('component.jquery')
    @include('component.datatables-script')
@endpush
