<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>

    <meta charset="utf-8" />
    <title>Smart &middot; BM3 {{ $title ? ' | ' . $title : '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ Storage::url('icon/favicon.png') }}">

    <!-- Select2 Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="/vendor/manage/assets/libs/magnific-popup/dist/magnific-popup.css">

    @stack('include-style')

    <!-- Layout config Js -->
    <script src="/vendor/manage/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/vendor/manage/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/vendor/manage/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/vendor/manage/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="/vendor/manage/assets/css/custom.min.css" rel="stylesheet" type="text/css" />


</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{ route('app.dashboard.index') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ Storage::url('icon/favicon.png') }}" alt="" height="40">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ Storage::url('logo/logo-dark.png') }}" alt="" height="30">
                                </span>
                            </a>

                            <a href="{{ route('app.dashboard.index') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ Storage::url('icon/favicon.png') }}" alt="" height="40">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ Storage::url('logo/logo-light.png') }}" alt="" height="30">
                                </span>
                            </a>
                        </div>

                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-md-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                                    id="search-options" value="">
                                <span class="mdi mdi-magnify search-widget-icon"></span>
                                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                                    id="search-close-options"></span>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex align-items-center">

                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..."
                                                aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user"
                                        src="{{ auth()->user()->photo() }}" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span
                                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                        <span
                                            class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ Auth::user()->getRoleNames()->implode(', ') }}</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Selamat Datang!</h6>
                                <a class="dropdown-item" href="#"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">Profil</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i
                                        class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle">Pengaturan</span></a>
                                <a class="dropdown-item" href="{{ route('auth.logout') }}"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Keluar</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="{{ route('app.dashboard.index') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ Storage::url('icon/favicon.png') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ Storage::url('logo/logo-dark.png') }}" alt="" height="30">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{ route('app.dashboard.index') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ Storage::url('icon/favicon.png') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ Storage::url('logo/logo-light.png') }}" alt="" height="30">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ set_active('app.dashboard.index') }}"
                                href="{{ route('app.dashboard.index') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-landing">Dashboard</span>
                            </a>
                        </li>

                        @if (auth()->user()->hasAnyPermission([
                                    'read salary',
                                    'read salary cut',
                                    'read allowance',
                                    'read last education',
                                    'read position',
                                    'print salary',
                                ]))
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.salaries*', 'app.salary_cut*', 'app.allowance*', 'app.last_education*', 'app.position*']) }}"
                                    href="#sidebarSalary" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarSalary">
                                    <i class="ri-money-dollar-circle-line"></i> <span
                                        data-key="t-report">Penggajian</span>
                                </a>
                                <div class="collapse menu-dropdown {{ set_active(['app.salaries*', 'app.salary_cut*', 'app.allowance*', 'app.last_education*', 'app.position*'], 'show') }}"
                                    id="sidebarSalary">
                                    <ul class="nav nav-sm flex-column">
                                        @can('read salary')
                                            <li class="nav-item">
                                                <a href="{{ route('app.salaries.index') }}"
                                                    class="nav-link {{ set_active('app.salaries*') }}"
                                                    data-key="t-transaction"> Input Penggajian</a>
                                            </li>
                                        @endcan

                                        @can('read salary cut')
                                            <li class="nav-item">
                                                <a href="{{ route('app.salary_cut.index') }}"
                                                    class="nav-link {{ set_active('app.salary_cut*') }}"
                                                    data-key="t-transaction"> Potongan
                                                </a>
                                            </li>
                                        @endcan

                                        @can('read allowance')
                                            <li class="nav-item">
                                                <a href="{{ route('app.allowance.index') }}"
                                                    class="nav-link {{ set_active('app.allowance*') }}"
                                                    data-key="t-transaction"> Tunjangan
                                                </a>
                                            </li>
                                        @endcan

                                        @can('read last education')
                                            <li class="nav-item">
                                                <a href="{{ route('app.last_education.index') }}"
                                                    class="nav-link {{ set_active('app.last_education*') }}"
                                                    data-key="t-transaction"> Data Pend. Terakhir
                                                </a>
                                            </li>
                                        @endcan

                                        @can('read position')
                                            <li class="nav-item">
                                                <a href="{{ route('app.position.index') }}"
                                                    class="nav-link {{ set_active('app.position*') }}"
                                                    data-key="t-transaction"> Data Jabatan
                                                </a>
                                            </li>
                                        @endcan

                                        @can('print salary')
                                            <li>
                                                <a href="{{ route('app.salary_slip.index') }}"
                                                    class="nav-link {{ set_active('app.salary_slip*') }}"
                                                    data-key="t-transaction"> Slip Gaji
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if (auth()->user()->is_hometeacher == '1' ||
                                auth()->user()->hasAnyPermission(['read achievement']))
                            <li class="menu-title"><span data-key="t-menu">WALAS</span></li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.achievement*']) }}"
                                    href="{{ route('app.achievement.index') }}">
                                    <i class="ri-medal-line"></i> <span data-key="t-landing">Prestasi</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->hasAnyPermission(['create absent', 'read absent']))
                            <li class="menu-title"><span data-key="t-point">Absen</span></li>
                        @endif
                        @can('create absent')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.absent.create*') }}"
                                    href="{{ route('app.absent.create') }}">
                                    <i class="ri-run-line"></i> <span data-key="t-point">Absen Terlambat</span>
                                </a>
                            </li>
                        @endcan
                        @can('read absent')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.absent.index*') }}"
                                    href="{{ route('app.absent.index') }}">
                                    <i class="ri-file-list-3-line"></i> <span data-key="t-point">Data Keterlambatan</span>
                                </a>
                            </li>
                        @endcan

                        @if (auth()->user()->hasAnyPermission(['read penalty point', 'read user penalty']))
                            <li class="menu-title"><span data-key="t-point">POIN SISWA/I</span></li>
                        @endif
                        @can('read user penalty')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.user_point*') }}"
                                    href="{{ route('app.user_point.index') }}">
                                    <i class="ri-file-warning-line"></i> <span data-key="t-point">Data Poin Siswa/i</span>
                                </a>
                            </li>
                        @endcan

                        @if (auth()->user()->hasAnyPermission(['read penalty point', 'read penalty category']))
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.penalty_point*', 'app.penalty_category*']) }}"
                                    href="#sidebarPointPenalty" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarPointPenalty">
                                    <i class="ri-auction-line"></i> <span data-key="t-point">Poin Pelanggaran</span>
                                </a>
                                <div class="collapse menu-dropdown {{ set_active(['app.penalty_point*', 'app.penalty_category*'], 'show') }}"
                                    id="sidebarPointPenalty">
                                    <ul class="nav nav-sm flex-column">
                                        @can('print salary')
                                            <li>
                                                <a href="{{ route('app.penalty_point.index') }}"
                                                    class="nav-link {{ set_active('app.penalty_point*') }}"
                                                    data-key="t-transaction"> Poin Pelanggaran
                                                </a>
                                            </li>
                                        @endcan
                                        @can('print salary')
                                            <li>
                                                <a href="{{ route('app.penalty_category.index') }}"
                                                    class="nav-link {{ set_active('app.penalty_category*') }}"
                                                    data-key="t-transaction"> Kategori
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @can('read penalty point')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.report_point*') }}"
                                    href="{{ route('app.report_point.index') }}">
                                    <i class="ri-file-list-3-line"></i> <span data-key="t-point">Laporan</span>
                                </a>
                            </li>
                        @endcan

                        @if (auth()->user()->hasAnyPermission(['read staff', 'read teacher', 'read teacher']))
                            <li class="menu-title"><span data-key="t-menu">User</span></li>
                        @endif
                        @can('read staff')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.staff*']) }}"
                                    href="{{ route('app.staff.index') }}">
                                    <i class="ri-user-2-line"></i> <span data-key="t-landing">Staff</span>
                                </a>
                            </li>
                        @endcan

                        @can('read teacher')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.teacher*') }}"
                                    href="{{ route('app.teacher.index') }}">
                                    <i class="ri-user-2-line"></i> <span data-key="t-landing">Guru</span>
                                </a>
                            </li>
                        @endcan

                        @can('read student')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.student*']) }}"
                                    href="{{ route('app.student.index') }}">
                                    <i class="ri-group-line"></i> <span data-key="t-landing">Siswa/Siswi</span>
                                </a>
                            </li>
                        @endcan

                        @role('developer')
                            <li class="menu-title"><span data-key="t-menu">Role & Permission</span></li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.role', 'app.role.*']) }}"
                                    href="{{ route('app.role.index') }}">
                                    <i class="ri-user-2-line"></i> <span data-key="t-landing">Role</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.permission', 'app.permission.*']) }}"
                                    href="{{ route('app.permission.index') }}">
                                    <i class="ri-group-line"></i> <span data-key="t-landing">Permission</span>
                                </a>
                            </li>
                        @endrole

                        @can('read work program category')
                            <li class="menu-title"><span data-key="t-menu">Program Kerja</span></li>
                        @endcan
                        @can('read work program')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.work_program*') }}"
                                    href="{{ route('app.work_program.index') }}">
                                    <i class="ri-file-settings-line"></i> <span data-key="t-landing">Proker Saya</span>
                                </a>
                            </li>
                        @endcan
                        @can('read work program default')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.work_program_default*') }}"
                                    href="{{ route('app.work_program_default.index') }}">
                                    <i class="ri-home-line"></i> <span data-key="t-landing">Proker Default</span>
                                </a>
                            </li>
                        @endcan
                        @can('read work program category')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.work_program_category*') }}"
                                    href="{{ route('app.work_program_category.index') }}">
                                    <i class="ri-list-check"></i> <span data-key="t-landing">Kategori Proker</span>
                                </a>
                            </li>
                        @endcan
                        @can('read value criteria')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.value_criteria*') }}"
                                    href="{{ route('app.value_criteria.index') }}">
                                    <i class="ri-sort-asc"></i> <span data-key="t-landing">Kriteria Penilaian</span>
                                </a>
                            </li>
                        @endcan

                        {{-- @can('finance access') --}}
                        @if (auth()->user()->hasAnyPermission(['read bill', 'read cost', 'read transaction']))
                            <li class="menu-title"><span data-key="t-menu">Keuangan</span></li>
                        @endif

                        @can('student read transaction')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.transaction.create*') }}"
                                    href="{{ route('app.transaction.create') }}">
                                    <i class="ri-exchange-line"></i> <span data-key="t-landing">Pembayaran</span>
                                </a>
                            </li>
                        @endcan

                        @can('student read transaction')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.transaction.index*') }}"
                                    href="{{ route('app.transaction.index') }}">
                                    <i class="ri-exchange-line"></i> <span data-key="t-landing">Riwayat Pembayaran</span>
                                </a>
                            </li>
                        @endcan

                        @can('create transaction')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.transaction*') }}"
                                    href="{{ route('app.transaction.create') }}">
                                    <i class="ri-exchange-line"></i> <span data-key="t-landing">Pembayaran</span>
                                </a>
                            </li>
                        @endcan

                        @can('read transaction')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app/finance/transaction', 'app/finance/transaction/create_detail/*']) }}"
                                    href="{{ route('app.finance.transaction.index') }}">
                                    <i class="ri-exchange-line"></i> <span data-key="t-landing">Data Transaksi</span>
                                </a>
                            </li>
                        @endcan

                        @can('read bill')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active('app.finance.bill*') }}"
                                    href="{{ route('app.finance.bill.index') }}">
                                    <i class="ri-funds-line"></i> <span data-key="t-landing">Tagihan Siswa/i</span>
                                </a>
                            </li>
                        @endcan

                        @can('read cost')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app/finance/cost', 'app/finance/cost/*']) }}"
                                    href="{{ route('app.finance.cost.index') }}">
                                    <i class="ri-money-dollar-circle-line"></i> <span data-key="t-landing">Biaya
                                        Sekolah</span>
                                </a>
                            </li>
                        @endcan

                        @can('read transaction report')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app/finance/report/transaction']) }}"
                                    href="#sidebarReport" data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="sidebarReport">
                                    <i class="ri-file-list-3-line"></i> <span data-key="t-report">Laporan</span>
                                </a>
                                <div class="collapse menu-dropdown {{ set_active('app/finance/report/transaction', 'show') }}"
                                    id="sidebarReport">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('app.finance.report.index', 'transaction') }}"
                                                class="nav-link {{ set_active('app/finance/report/transaction') }}"
                                                data-key="t-transaction"> Transaksi</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @if (auth()->user()->hasAnyPermission(['read loan member', 'read loan']))
                            <li class="menu-title"><span data-key="t-menu">Peminjaman</span></li>
                        @endif
                        @can('read loan member')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.loan_member*']) }}"
                                    href="{{ route('app.loan_member.index') }}">
                                    <i class="ri-group-line"></i> <span data-key="t-landing">Anggota</span>
                                </a>
                            </li>
                        @endcan
                        @can('read loan')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.loan.*']) }}"
                                    href="{{ route('app.loan.index') }}">
                                    <i class="ri-key-line"></i> <span data-key="t-landing">Peminjaman</span>
                                </a>
                            </li>
                        @endcan

                        @if (auth()->user()->hasAnyPermission(['read building', 'read room', 'read facility', 'read submission']))
                            <li class="menu-title"><span data-key="t-menu">Sarpras</span></li>
                        @endif
                        @can('read building')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.building*']) }}"
                                    href="{{ route('app.building.index') }}">
                                    <i class="ri-building-line"></i> <span data-key="t-landing">Gedung</span>
                                </a>
                            </li>
                        @endcan
                        @can('read room')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.room*']) }}"
                                    href="{{ route('app.room.index') }}">
                                    <i class="ri-door-line"></i> <span data-key="t-landing">Ruangan</span>
                                </a>
                            </li>
                        @endcan
                        @can('read facility')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.facility*']) }}"
                                    href="{{ route('app.facility.index') }}">
                                    <i class="ri-projector-2-line"></i> <span data-key="t-landing">Fasilitas</span>
                                </a>
                            </li>
                        @endcan

                        @can('read submission')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.submission*']) }}"
                                    href="{{ route('app.submission.index') }}">
                                    <i class="ri-quill-pen-fill"></i> <span data-key="t-landing">Pengajuan</span>
                                </a>
                            </li>
                        @endcan

                        @can('read facility')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.service*']) }}"
                                    href="{{ route('app.service.index') }}">
                                    <i class="ri-customer-service-2-fill"></i> <span data-key="t-landing">Service</span>
                                </a>
                            </li>
                        @endcan

                        @if (auth()->user()->hasAnyPermission(['read picket schedule']))
                            <li class="menu-title"><span data-key="t-menu">Admin Piket</span></li>
                        @endif
                        @can('create picket absent')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.picket_absent*']) }}"
                                    href="{{ route('app.picket_absent.index') }}">
                                    <i class="ri-file-edit-line"></i> <span data-key="t-landing">Absen Siswa</span>
                                </a>
                            </li>
                        @endcan
                        @can('create teacher absent')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.teacher_absent*']) }}"
                                    href="{{ route('app.teacher_absent.index') }}">
                                    <i class="ri-file-edit-fill"></i> <span data-key="t-landing">Absen Guru</span>
                                </a>
                            </li>
                        @endcan
                        @can('create student apprenticeship')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.student_apprenticeship*']) }}"
                                    href="{{ route('app.student_apprenticeship.index') }}">
                                    <i class="ri-user-shared-2-line"></i> <span data-key="t-landing">Siswa PKL</span>
                                </a>
                            </li>
                        @endcan
                        @can('read picket schedule')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.picket_schedule*']) }}"
                                    href="{{ route('app.picket_schedule.index') }}">
                                    <i class="ri-file-list-2-line"></i> <span data-key="t-landing">Jadwal Piket</span>
                                </a>
                            </li>
                        @endcan
                        @can('read picket report')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.picket_report*']) }}"
                                    href="{{ route('app.picket_report.index') }}">
                                    <i class="ri-file-list-2-fill"></i> <span data-key="t-landing">Laporan Piket</span>
                                </a>
                            </li>
                        @endcan
                        @if (auth()->user()->hasAnyPermission(['read letter']))
                            <li class="menu-title"><span data-key="t-menu">Operator</span></li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.letter_category*']) }}"
                                    href="{{ route('app.letter_category.index') }}">
                                    <i class="ri-file-copy-2-line"></i> <span data-key="t-landing">Kategori
                                        Surat</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ set_active(['app.letter*']) }}"
                                    href="{{ route('app.letter.index') }}">
                                    <i class="ri-file-list-3-line"></i> <span data-key="t-landing">Surat</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ $title ?? 'No Title Page' }}</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <!-- <li class="breadcrumb-item"><a href="/vendor/manage/javascript: void(0);">Pages</a></li> -->
                                        <li class="breadcrumb-item active">{{ strftime('%d %B %Y') }} <span
                                                id="liveClock">00:00:00</span></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">{{ date('Y') }} © smartbm3.com</div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Engined by Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP
                                v{{ PHP_VERSION }})
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('component.jquery')
    <script src="/vendor/manage/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/manage/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/vendor/manage/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/vendor/manage/assets/js/plugins.js"></script>

    <!-- Select2 Js -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    {{-- <script src="/vendor/manage/assets/js/pages/select2.init.js"></script> --}}

    <!-- Magnific Popup core JS file -->
    <script src="/vendor/manage/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>

    <!-- Function js -->
    <script src="/vendor/manage/assets/js/function.js"></script>

    @include('component.alert')
    @include('component.confirm')

    <!-- App js -->
    <script src="/vendor/manage/assets/js/app.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        // select2
        $(".select2").select2({
            theme: "bootstrap-5",
            // dropdownParent: $(".modal")
        });

        $(document).on("keypress", ".select2", function(event) {
            if (event.ctrlKey || event.metaKey) {
                var id = $(this).parents("div[class*='select2-container']").attr("id").replace("s2id_", "");
                var element = $("#" + id);
                if (event.which == 97) {
                    var selected = [];
                    element.find("option").each(function(i, e) {
                        selected[selected.length] = $(e).attr("value");
                    });
                    element.select2("val", selected);
                } else if (event.which == 100) {
                    element.select2("val", "");
                }
            }
        });

        // Calculate Year of Experience
        window.onload = function() {
            $('.entry_date').on('change', function() {
                var dob = new Date(this.value);
                var today = new Date();
                var experience = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
                $('.year_experience').val(experience);
            });

        }

        function yearExperience(entry_date) {
            var dob = new Date(entry_date);
            var today = new Date();
            var experience = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
            $('.year_experience').val(experience);
        }

        // Input Currency
        $('.currency').blur(function() {
            var formatter = new Intl.NumberFormat('en-US', {
                style: 'decimal',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });

            const value = this.value.replace(/,/g, '');
            this.value != 0 ? this.value = formatter.format(value) : this.value = 0;
        });

        // Time
        setInterval(() => document.querySelector("#liveClock").innerHTML = new Date().toLocaleTimeString(), 1000);
    </script>

    @stack('include-script')
</body>

</html>
