@extends('layouts.manage', ['title' => 'Staff'])

@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.staff.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Staff</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.staff.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Nama</label>
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
                                <label for="nip" class="form-label">NIP</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                                    id="nip" value="{{ old('nip') }}">
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
                                    value="{{ old('username') }}">
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
                                    value="{{ old('email') }}">
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
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                                <div class="row align-items-center mt-3">
                                    <div class="col-sm-4">
                                        <label for="re-password" class="form-label">Ulangi Password</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="password" name="re-password"
                                            class="form-control @error('re-password') is-invalid @enderror"
                                            id="re-password">
                                        @error('re-password')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="roles" class="form-label">Role</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select select2 @error('roles') is-invalid @enderror" name="roles[]"
                                    id="roles" multiple data-placeholder="Pilih Role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ select_old_multiple($role->id, old('roles')) }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles')
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
                                <select class="form-select" name="last_education"
                                    id="last_education">
                                    <option value="">Pend. Terakhir</option>
                                    @foreach ($last_educations as $last_education)
                                        <option value="{{ $last_education->id }}"
                                            {{ select_old($last_education->id, old('last_education')) }}>
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

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="entry_date" class="form-label">Tanggal Masuk</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="mb-3">
                                    <input type="date" name="entry_date"
                                        class="form-control entry_date @error('entry_date') is-invalid @enderror"
                                        id="entry_date" value="{{ old('entry_date') }}">
                                    @error('entry_date')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="entry_date" class="form-label">Masa Kerja</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control year_experience" disabled>
                                            <span class="input-group-text">Tahun</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="Status" class="form-label">Status</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('status') is-invalid @enderror" name="status"
                                    id="Status">
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="GTY" {{ select_old('GTY', old('status')) }}>GTY</option>
                                    <option value="GTT" {{ select_old('GTT', old('status')) }}>GTT</option>
                                    <option value="KTY" {{ select_old('KTY', old('status')) }}>KTY</option>
                                    <option value="KTT" {{ select_old('KTT', old('status')) }}>KTT</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="gender" class="form-label">Gender</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('gender') is-invalid @enderror" name="gender"
                                    id="gender">
                                    <option value="" hidden>Pilih Gender</option>
                                    <option value="Pria" {{ select_old('Pria', old('gender')) }}>Pria</option>
                                    <option value="Wanita" {{ select_old('Wanita', old('gender')) }}>Wanita
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="marital_status" class="form-label">Status Perkawinan</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('marital_status') is-invalid @enderror"
                                    name="marital_status" id="marital_status">
                                    <option value="" hidden>Pilih Status Perkawinan</option>
                                    <option value="1" {{ select_old('1', old('marital_status')) }}>Menikah
                                    </option>
                                    <option value="0" {{ select_old('0', old('marital_status')) }}>Belum
                                        Menikah
                                    </option>
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="child" class="form-label">Jumlah Anak</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="child"
                                    class="form-control @error('child') is-invalid @enderror" id="child"
                                    value="{{ old('child') ?? 0 }}">
                                @error('child')
                                    <div class="invalid-feedback">
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
