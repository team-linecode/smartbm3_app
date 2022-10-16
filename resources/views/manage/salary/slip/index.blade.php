@extends('layouts.manage', ['title' => 'Slip Gaji'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="">
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Data slip gaji</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Bulan</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salaryDetails as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('F Y', strtotime($detail->salary->month)) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="view">
                                            <a href="{{ route('app.salaries.generate_pdf', [$detail->uid, 'stream']) }}"
                                                target="_blank" class="btn btn-primary btn-sm">Lihat Slip</a>
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
