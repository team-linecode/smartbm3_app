@extends('layouts.manage', ['title' => 'Ganti Password'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.teacher.edit', $teacher->id) }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Ganti Password</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.teacher.save_password', $teacher->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label class="form-label">Nama</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="text-primary fw-bold mb-2">{{ $teacher->name }}</div>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label class="form-label">Username</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="text-primary fw-bold mb-2">{{ $teacher->username }}</div>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="old_password" class="form-label">Password Lama</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="old_password"
                                    class="form-control @error('old_password') is-invalid @enderror" id="old_password"
                                    value="{{ old('old_password') }}">
                                @error('old_password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="password" class="form-label">Password Baru</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password"
                                    value="{{ old('password') }}">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="re_password" class="form-label">Ulangi Password Baru</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="re_password"
                                    class="form-control @error('re_password') is-invalid @enderror" id="re_password"
                                    value="{{ old('re_password') }}">
                                @error('re_password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-9 offset-lg-3 mb-3">
                            <button class="btn btn-primary ms-1">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
