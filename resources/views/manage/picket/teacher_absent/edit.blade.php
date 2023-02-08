@extends('layouts.manage', ['title' => 'Absensi Guru'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.teacher_absent.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Absensi Guru</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.teacher_absent.update', $teacher_absent->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="user" class="form-label">Guru</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control select2 @error('user') is-invalid @enderror" name="user" id="user">
                                    <option value="" hidden>Pilih Guru</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ select_old($user->id, old('user'), true, $teacher_absent->user_id) }}>
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
                                <label for="statuses" class="form-label">Status</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('status') is-invalid @enderror" name="status" id="statuses">
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="s" {{ select_old('s', old('status'), true, $teacher_absent->status) }}>Sakit</option>
                                    <option value="i" {{ select_old('i', old('status'), true, $teacher_absent->status) }}>Izin</option>
                                </select>
                                @error('status')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="description" class="form-label">Keterangan Tambahan <span
                                        class="text-success">*</span></label>
                            </div>
                            <div class="col-sm-9">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') ?? $teacher_absent->description }}</textarea>
                                @error('description')
                                    <div class="small text-danger mt-1">
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
