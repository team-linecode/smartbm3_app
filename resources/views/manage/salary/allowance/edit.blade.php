@extends('layouts.manage', ['title' => 'Tunjangan'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.allowance.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Ubah Tunjangan</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.allowance.update', $allowance->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Nama</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') ?? $allowance->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="description" class="form-label">Keterangan</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                    id="description" rows="2">{{ old('description') ?? $allowance->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="amount" class="form-label">Jumlah (Rp.)</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="amount"
                                    class="form-control currency @error('amount') is-invalid @enderror" id="amount"
                                    value="{{ old('amount') ?? number_format($allowance->amount) }}">
                                @error('amount')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-end">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('manage.salary.allowance.formula')
    </div>
@stop
