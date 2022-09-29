@extends('layouts.manage', ['title' => 'Staff'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.staff.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Staff</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.staff.update', $staff->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Nama</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') ?? $staff->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="nip" class="form-label">NIP</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                                    id="nip" value="{{ old('nip') ?? $staff->nip }}">
                                @error('nip')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="username" class="form-label">Username</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror" id="username"
                                    value="{{ old('username') ?? $staff->username }}">
                                @error('username')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="email" class="form-label">Email</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    value="{{ old('email') ?? $staff->email }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="password" class="form-label mt-2">Password</label>
                            </div>
                            <div class="col-sm-9">
                                <a href="{{ route('app.staff.change_password', $staff->id) }}" class="btn btn-primary"><i
                                        class="ri ri-lock-line align-bottom"></i> Ganti
                                    Password</a>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="role" class="form-label">Role</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" data-choices data-choices-search-false name="role"
                                    id="role">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ select_old($role->id, old('role'), true, $staff->role_id) }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="last_education" class="form-label">Pend. Terakhir</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" data-choices data-choices-search-false name="last_education"
                                    id="last_education">
                                    <option value="">Pend. Terakhir</option>
                                    @foreach ($last_educations as $last_education)
                                        <option value="{{ $last_education->id }}"
                                            {{ select_old($last_education->id, old('last_education'), true, $staff->last_education_id) }}>
                                            {{ $last_education->name }} | {{ $last_education->alias }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('last_education')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="picture" class="form-label">Foto</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="picture"
                                    accept="image/png, image/jpeg, image/gif" />
                                @error('picture')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                                @if ($staff->image != null)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-lg mt-3">
                                            <img src="{{ Storage::url($staff->image) }}" alt="user-img"
                                                class="img-thumbnail rounded-circle"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                        <a href="{{ route('app.staff.destroy_image', $staff->id) }}"
                                            class="btn btn-danger"
                                            onclick="return confirm('Hapus foto untuk siswa ini?')">
                                            <i class="ri ri-delete-bin-line align-bottom"></i> Hapus Foto
                                        </a>
                                    </div>
                                @endif
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
