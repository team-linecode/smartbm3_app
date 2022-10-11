@extends('layouts.manage', ['title' => 'Penggajian'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="align-items-start">
                    <div class="d-block d-md-none d-lg-none d-xl-none">
                        <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Slip Gaji
                            {{ date('F Y', strtotime($salary->month)) }}</h4>
                        <p class="text-center text-muted mb-md-0 mb-lg-0">Ukuran Kertas Slip Gaji adalah F4</p>
                    </div>
                    <div class="d-none d-md-block d-lg-block d-xl-block">
                        <h4 class="card-title text-uppercase mb-2 mb-md-0 mb-lg-0">Slip Gaji
                            {{ date('F Y', strtotime($salary->month)) }}</h4>
                        <p class="text-muted mb-md-0 mb-lg-0">Ukuran Kertas Slip Gaji adalah F4</p>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.salaries.index') }}" class="btn btn-primary">Slip Gaji</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salary->details as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->user->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="view">
                                            <a href="{{ route('app.salaries.generate_pdf', [$detail->uid, 'stream']) }}"
                                                class="btn btn-primary btn-sm">Lihat Slip</a>
                                        </div>
                                        <div class="download">
                                            <a href="{{ route('app.salaries.generate_pdf', [$detail->uid, 'download']) }}"
                                                class="btn btn-success btn-sm">Download Slip</a>
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
    @include('component.datatables-script')
@endpush
