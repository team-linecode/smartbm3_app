@extends('layouts.manage', ['title' => 'Poin Pelanggaran'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.penalty_point.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Permission</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.penalty_point.update', $penalty_point->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Nama</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') ?? $penalty_point->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="point" class="form-label">Poin</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="point"
                                    class="form-control @error('point') is-invalid @enderror" id="point"
                                    value="{{ old('point') ?? $penalty_point->point }}">
                                @error('point')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop