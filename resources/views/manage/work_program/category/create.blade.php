@extends('layouts.manage', ['title' => 'Program Kerja'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.work_program_category.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Kategori</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.work_program_category.store') }}" method="post">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Kategori</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="percentage" class="form-label">Persentase (%)</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" name="percentage"
                                        class="form-control @error('percentage') is-invalid @enderror" id="percentage"
                                        value="{{ old('percentage') }}">
                                    <span class="input-group-text" id="suffixId">%</span>
                                </div>
                                @error('percentage')
                                    <div class="small text-danger pt-1">
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
