@extends('layouts.manage', ['title' => 'Transaksi'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')

    @include('component.form-error')

    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Data Transaksi</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.finance.transaction.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
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
                                        {{ $trans->user->expertise->alias }}</small>
                                </td>
                                <td>Rp{{ number_format($trans->total) }}</td>
                                <td>{!! $trans->status() !!}</td>
                                <td>{{ strftime('%d %B %Y', strtotime($trans->date)) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
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
