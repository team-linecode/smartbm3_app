@extends('layouts.manage', ['title' => 'Kategori Surat'])

@push('include-style')
@include('component.datatables-style')
@endpush

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                    <div>
                        <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Kategori Surat</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('app.letter_category.update', $lettercategory->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <label for="">Name</label>
                    <input type="text" placeholder="Categories Name" class="form-control" name="name" id="name" value="{{ $lettercategory->name }}" require>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-sm btn-primary mt-1 float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('include-script')
@include('component.datatables-script')
@endpush