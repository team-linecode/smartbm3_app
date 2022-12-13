@extends('layouts.manage', ['title' => 'Facility'])

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <a href="{{ route('app.facility.index') }}" class="btn btn-primary">
                            <i class="ri ri-arrow-left-line"></i>
                        </a>
                    </div>
                    <div>
                        <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Sarana</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('app.facility.store') }}" method="post">
                    @csrf
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-3">
                            <label for="name" class="form-label">Nama Sarana</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-3">
                            <label for="brand" class="form-label">Merek</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" id="brand" value="{{ old('brand') }}">
                            @error('brand')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start mb-5">
                        <div class="col-sm-3">
                            <label for="description" class="form-label">Deskripsi/Keterangan</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" value="{{ old('description') }}">
                            @error('description')
                            <div class="small text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-9 offset-sm-3">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary">Simpan</button>
                                <div class="form-check ms-3">
                                    <input class="form-check-input" name="stay" type="checkbox" id="checkboxStay">
                                    <label class="form-check-label" for="checkboxStay">
                                        Tetap dihalaman ini
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop