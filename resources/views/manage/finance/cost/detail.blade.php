@extends('layouts.manage', ['title' => 'Biaya Sekolah'])

@push('include-style')
@include('component.datatables-style')
@endpush

@section('content')

@include('component.form-error')

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-center">
                <a href="{{ route('app.finance.cost.show', $schoolyear->slug) }}" class="btn btn-light me-2"><i class="ri-arrow-left-s-line"></i></a>
                <h4 class="card-title text-center text-uppercase mb-0 d-inline">Detail Biaya</h4>
            </div>
            <div>
                <form action="{{ route('app.finance.cost.destroy', [$schoolyear->slug, $cost->slug]) }}" class="d-inline" method="post">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-danger c-delete"><i class="ri-delete-bin-line align-middle"></i> Hapus</button>
                </form>
                <a href="{{ route('app.finance.cost.edit', [$schoolyear->slug, $cost->slug]) }}" class="btn btn-success"><i class="ri-edit-line align-middle"></i> Edit</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3">
                <label class="form-label">Nama Biaya</label>
            </div>
            <div class="col-lg-9">
                <p>{{ $cost->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label class="form-label">Kategori</label>
            </div>
            <div class="col-lg-9">
                <p>{{ $cost->cost_category->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label class="form-label">Tahun Ajaran</label>
            </div>
            <div class="col-lg-9">
                <p>{{ $cost->schoolyear->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <label class="form-label mb-0">Keterangan</label>
            </div>
            <div class="col-lg-9">
                <p class="mb-0">{{ $cost->cost_category->description }}</p>
            </div>
        </div>
    </div>
</div>

@if($cost->cost_category->slug == 'spp')
@include('manage.finance.cost.detail_page.spp')
@elseif($cost->cost_category->slug == 'ujian')
@include('manage.finance.cost.detail_page.ujian')
@elseif($cost->cost_category->slug == 'daftar-ulang')
@include('manage.finance.cost.detail_page.daftar-ulang')
@elseif($cost->cost_category->slug == 'gedung')
@include('manage.finance.cost.detail_page.gedung')
@elseif($cost->cost_category->slug == 'lain-lain')
@include('manage.finance.cost.detail_page.lain-lain')
@endif

{{-- <div class="row">
    @foreach($classrooms as $classroom)
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title fw-bold text-center text-uppercase mb-0">Kelas {{ $classroom->alias }}</h4>
</div>
<div class="card-body">
    <div class="table-card">
        <table class="table text-center mb-0">
            <tbody>
                <tr class="bg-light">
                    <td class="fw-bold" style="width: 33.3%;">Gelombang</td>
                    <td class="fw-bold" style="width: 33.3%;">Jumlah (Rp.)</td>
                </tr>
                @foreach($classroom->details($cost->id) as $cost_detail)
                <tr>
                    <td style="width: 33.3%;">-</td>
                    <td style="width: 33.3%;">Rp. 0</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!--end table-->
    </div>
</div>
</div>
</div>
@endforeach
</div> --}}
@stop

@push('include-script')
@include('component.jquery')
@include('component.datatables-script')
@endpush
