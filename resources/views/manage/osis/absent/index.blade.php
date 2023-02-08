@extends('layouts.manage', ['title' => 'Data Poin'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Data siswa terlambat hari ini
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">Point</th>
                            <th scope="col">Tanggal&nbsp;&&nbsp;Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user_points as $user_point)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user_point->user->name }}</td>
                                <td>{!! $user_point->user->myClass() !!}</td>
                                <td>
                                    @if ($user_point->description != null)
                                        {{ $user_point->description }}
                                    @else
                                        <div class="d-flex">
                                            <div class="fw-medium me-2">
                                                {{ $user_point->penalty->code }}
                                            </div>
                                            <div>
                                                {{ $user_point->penalty->name }}
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($user_point->type == 'plus')
                                        <i
                                            class="h5 align-middle ri-arrow-up-line text-danger"></i>&nbsp;Penambahan&nbsp;Poin
                                    @elseif ($user_point->type == 'minus')
                                        <i
                                            class="h5 align-middle ri-arrow-down-line text-success"></i>&nbsp;Pengurangan&nbsp;Poin
                                    @endif
                                </td>
                                <td class="fw-medium">
                                    {{ $user_point->type == 'plus' ? '+' : '-' }}{{ $user_point->point ?? $user_point->penalty->point }}
                                </td>
                                <td>{!! str_replace(' ', '&nbsp;', date('d-m-Y / H:i', $user_point->date())) !!}</td>
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
