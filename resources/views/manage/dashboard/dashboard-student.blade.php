@extends('layouts.manage', ['title' => 'Dashboard'])

@push('include-style')
    @include('component.datatables-style')
    @include('component.swiper-style')
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
                        <li class="nav-item">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#achievement-tab" role="tab">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">Prestasi</span>
                            </a>
                        </li>
                    </ul>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-success disabled"><i class="ri-edit-box-line align-bottom"></i>
                            Edit Profile</a>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <!-- Swiper -->
                        <div class="swiper sw-achievement">
                            <div class="swiper-wrapper">
                                @foreach (auth()->user()->achievements as $achievement)
                                    <div class="swiper-slide">
                                        <div class="card">
                                            <div class="card-body overflow-hidden">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <img src="{{ is_numeric($achievement->champion) ? Storage::url('icon/award.png') : Storage::url('icon/medal.png') }}"
                                                            width="90">
                                                    </div>
                                                    <div>
                                                        <small class="d-inline-block">Selamat atas prestasimu!</small>
                                                        <h6 class="text-primary mb-0">Meraih Juara
                                                            {{ $achievement->champion }}
                                                        </h6>
                                                        <h6 class="fw-bold">{{ $achievement->name }}</h6>
                                                        <h6>Tingkat {{ $achievement->level }}</h6>
                                                        <p class="mb-0">
                                                            {{ date('d F Y', strtotime($achievement->date)) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-5">Poin Pelanggaran</h5>
                                        <div class="progress animated-progress custom-progress progress-label">
                                            <div class="progress-bar {{ auth()->user()->point_color() }}"
                                                role="progressbar" style="width: {{ auth()->user()->total_points() }}%"
                                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                <div class="label">{{ auth()->user()->total_points() . ' Point' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">TOTAL SAKIT BULAN INI</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span
                                                                class="counter-value"
                                                                data-target="{{ $s }}">{{ $s }}</span>
                                                        </h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-thermometer text-info">
                                                                    <path
                                                                        d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-4">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">TOTAL IZIN BULAN INI</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span
                                                                class="counter-value"
                                                                data-target="{{ $i }}">{{ $i }}</span>
                                                        </h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">


                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-file-text text-info">
                                                                    <path
                                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                    </path>
                                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                                    <line x1="16" y1="13" x2="8"
                                                                        y2="13"></line>
                                                                    <line x1="16" y1="17" x2="8"
                                                                        y2="17"></line>
                                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-4">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">TOTAL ALPA BULAN INI</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span
                                                                class="counter-value"
                                                                data-target="{{ $a }}">{{ $a }}</span>
                                                        </h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">

                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-alert-triangle text-info">
                                                                    <path
                                                                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                                                    </path>
                                                                    <line x1="12" y1="9" x2="12"
                                                                        y2="13"></line>
                                                                    <line x1="12" y1="17" x2="12.01"
                                                                        y2="17"></line>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
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
                                                                        class="h5 align-middle ri-arrow-up-line text-danger"></i>&nbsp;Penambahan&nbsp;Poin
                                                                @elseif ($user_point->type == 'minus')
                                                                    <i
                                                                        class="h5 align-middle ri-arrow-down-line text-success"></i>&nbsp;Pengurangan&nbsp;Poin
                                                                @endif
                                                            </td>
                                                            <td>{{ $user_point->point ?? $user_point->penalty->point }}
                                                            </td>
                                                            <td>{!! str_replace(' ', '&nbsp;', date('d-m-Y', $user_point->date())) !!}</td>
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
                    <div class="tab-pane" id="achievement-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-5">Prestasi yang Diraih</h5>
                                        @if (auth()->user()->achievements->count() == 0)
                                            <div class="row justify-content-center text-center">
                                                <div class="col-lg-6">
                                                    <img src="{{ Storage::url('background/trophy.jpg') }}"
                                                        width="200">
                                                    <h5>Jangan pernah meragukan potensimu, karena kamu mampu mencapai
                                                        prestasi
                                                        yang luar biasa.</h5>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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
    @include('component.swiper-script')
@endpush
