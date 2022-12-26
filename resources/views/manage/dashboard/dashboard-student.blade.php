@extends('layouts.manage', ['title' => 'Dashboard'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{ Storage::url('background/classroom.jpg') }}" alt="" class="profile-wid-img" />
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-lg">
                    <img src="{{ auth()->user()->photo() }}" alt="user-img" class="img-thumbnail rounded-circle" />
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-white-75">{{ ucwords(auth()->user()->roles->pluck('name')->implode(',')) }}</p>
                    <div class="hstack text-white-50 gap-1">
                        <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>
                            {{ auth()->user()->myClass() }}</div>
                        <div class="me-2"><i class="ri-information-line me-1 text-white-75 fs-16 align-middle"></i>
                            {{ auth()->user()->alumni == 0 ? 'Belum Lulus' : 'Sudah Lulus' }}</div>
                    </div>
                </div>
            </div>

        </div>
        <!--end row-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">Poin Saya</span>
                            </a>
                        </li>
                    </ul>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-success disabled"><i
                                class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-5">Poin Pelanggaran</h5>
                                        <div class="progress animated-progress custom-progress progress-label">
                                            <div class="progress-bar {{ auth()->user()->point_color() }}" role="progressbar"
                                                style="width: {{ auth()->user()->total_points() }}%" aria-valuenow="30"
                                                aria-valuemin="0" aria-valuemax="100">
                                                <div class="label">{{ auth()->user()->total_points() . ' Point' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Riwayat Poin</h5>
                                        <div class="table-responsive table-card">
                                            <table class="table align-middle w-100 mb-0 datatables">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">No</th>
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
                                                            <td>{{ $user_point->description ?? $user_point->penalty->name }}
                                                            </td>
                                                            <td>
                                                                @if ($user_point->type == 'plus')
                                                                    <i
                                                                        class="h5 align-middle ri-add-circle-fill text-danger"></i>&nbsp;Penambahan&nbsp;Poin
                                                                @elseif ($user_point->type == 'minus')
                                                                    <i
                                                                        class="h5 align-middle ri-indeterminate-circle-fill text-success"></i>&nbsp;Pengurangan&nbsp;Poin
                                                                @endif
                                                            </td>
                                                            <td>{{ $user_point->point ?? $user_point->penalty->point }}
                                                            </td>
                                                            <td>{!! str_replace(' ', '&nbsp;', date('d-m-Y / H:i', $user_point->date())) !!}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- end table -->
                                        </div>
                                        <!-- end table responsive -->
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <!--end tab-content-->
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@stop

@push('include-script')
    @include('component.datatables-script')
@endpush
