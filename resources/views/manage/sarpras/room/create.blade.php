@extends('layouts.manage', ['title' => 'Ruangan'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.room.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Ruangan</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.room.store') }}" method="post">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Nama Ruangan</label>
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
                                <label for="building" class="form-label">Letak Gedung</label>
                            </div>
                            <div class="col-sm-9">
                                <select type="text" name="building" class="form-select @error('building') is-invalid @enderror" id="building">
                                    <option value="" hidden>Pilih Gedung</option>
                                    <option value="" {{ select_old('', old('building')) }}>Gedung A</option>
                                    <option value="" {{ select_old('', old('building')) }}>Gedung B</option>
                                </select>
                                @error('building')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="stage" class="form-label">Pada Lantai</label>
                            </div>
                            <div class="col-sm-9">
                                <select type="text" name="stage" class="form-select @error('stage') is-invalid @enderror" id="stage">
                                    <option value="" hidden>Pilih Lantai</option>
                                    <option value="" {{ select_old('', old('stage')) }}>Lantai 1</option>
                                    <option value="" {{ select_old('', old('stage')) }}>Lantai 2</option>
                                    <option value="" {{ select_old('', old('stage')) }}>Lantai 3</option>
                                </select>
                                @error('stage')
                                    <div class="invalid-feedback">
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
