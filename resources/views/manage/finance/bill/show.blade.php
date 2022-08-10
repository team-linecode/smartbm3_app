@extends('layouts.manage', ['title' => 'Tagihan Siswa'])

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-center">
                <a href="{{ route('app.finance.bill.index') }}" class="btn btn-light me-2"><i class="ri-arrow-left-s-line"></i></a>
                <h4 class="card-title text-center text-uppercase mb-0 d-inline">Detail Tagihan</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label">Nama Siswa</label>
                    </div>
                    <div class="col-lg-8">
                        <p>{{ $user->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label">Kelas</label>
                    </div>
                    <div class="col-lg-8">
                        <p>{{ $user->myClass(true) }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label">Tipe Pendaftaran</label>
                    </div>
                    <div class="col-lg-8">
                        <p>{{ $user->group->alias }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label">Tahun Ajaran</label>
                    </div>
                    <div class="col-lg-8">
                        <p>{{ $user->schoolyear->name }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <p class="fw-bold">Rincian Keselurahan Biaya :</p>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label">Total Biaya</label>
                    </div>
                    <div class="col-lg-8">
                        <p>Rp. {{ number_format($user->total_all_cost()) }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label">Total Dibayarkan</label>
                    </div>
                    <div class="col-lg-8">
                        <p>Rp. {{ number_format($user->total_all_paid()) }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label class="form-label">Total Sisa</label>
                    </div>
                    <div class="col-lg-8">
                        <p>Rp. {{ number_format($user->total_all_remaining()) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($user->schoolyear->costs()->orderBy('cost_category_id')->get() as $cost)
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">{{ $cost->name }}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            @if($cost->cost_category->slug == 'spp' || $cost->cost_category->slug == 'daftar-ulang')
            @include('manage.finance.bill.detail_page.table_classroom')
            @elseif($cost->cost_category->slug == 'ujian')
            @include('manage.finance.bill.detail_page.table_semester')
            @elseif($cost->cost_category->slug == 'gedung')
            @include('manage.finance.bill.detail_page.table_group')
            @elseif($cost->cost_category->slug == 'lain-lain')
            @endif
        </div>
    </div>
</div>
@endforeach
@stop