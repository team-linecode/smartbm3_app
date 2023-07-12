@extends('layouts.manage', ['title' => 'Data Jabatan'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.position.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Jabatan</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.position.store') }}" method="post">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="user" class="form-label">Staff/Guru</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" data-choices data-choices-removeItem multiple name="user[]"
                                    id="user">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ select_old_multiple($user->id, old('user')) }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Jabatan</label>
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
                                <label for="salary" class="form-label">Gaji</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="salary"
                                    class="form-control currency @error('salary') is-invalid @enderror" id="salary"
                                    value="{{ old('salary') }}">
                                @error('salary')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="internal" class="form-label">Staff Internal</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="staff_internal" id="staff_internal_y" value="y">
                                    <label class="form-check-label" for="staff_internal_y">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="staff_internal" id="staff_internal_n" value="n">
                                    <label class="form-check-label" for="staff_internal_n">
                                        Tidak
                                    </label>
                                </div>
                                @error('staff_internal')
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
    </div>
@stop
