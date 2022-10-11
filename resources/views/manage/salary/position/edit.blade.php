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
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Jabatan</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.position.update', $position->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="user" class="form-label">Staff/Guru</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" data-choices data-choices-removeItem multiple name="user[]" id="user">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ select_old_multiple($user->id, old('user'), true, $position->users->pluck('id')->toArray()) }}>
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
                                    value="{{ old('name') ?? $position->name }}">
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
                                    value="{{ old('salary') ?? number_format($position->salary) }}">
                                @error('salary')
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
