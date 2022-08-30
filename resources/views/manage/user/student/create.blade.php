@extends('layouts.manage', ['title' => 'Tambah Siswa'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.student.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Siswa</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.student.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
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
                                        <label for="nisn" class="form-label">NISN</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="nisn"
                                            class="form-control @error('nisn') is-invalid @enderror" id="nisn"
                                            value="{{ old('nisn') }}">
                                        @error('nisn')
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

                                        <div class="row align-items-center my-3">
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
                            </div>
                            <div class="col-lg-6">
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="classroom" class="form-label">Kelas</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" data-choices data-choices-search-false name="classroom"
                                            id="classroom">
                                            <option value="">Pilih Kelas</option>
                                            @foreach ($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}"
                                                    {{ select_old($classroom->id, old('classroom')) }}>
                                                    {{ $classroom->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('classroom')
                                            <div class="small text-danger mt-1">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="expertise" class="form-label">Jurusan</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" data-choices data-choices-search-false
                                            data-choices-sorting-false name="expertise" id="expertise">
                                            <option value="">Pilih Jurusan</option>
                                            @foreach ($expertises as $expertise)
                                                <option value="{{ $expertise->id }}"
                                                    {{ select_old($expertise->id, old('expertise')) }}>
                                                    {{ $expertise->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('expertise')
                                            <div class="small text-danger mt-1">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="schoolyear" class="form-label">Tahun Ajaran</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" data-choices data-choices-search-false
                                            data-choices-sorting-false name="schoolyear" id="schoolyear">
                                            <option value="">Pilih Tahun Ajaran</option>
                                            @foreach ($schoolyears as $schoolyear)
                                                <option value="{{ $schoolyear->id }}"
                                                    {{ select_old($schoolyear->id, old('schoolyear')) }}>
                                                    {{ $schoolyear->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('schoolyear')
                                            <div class="small text-danger mt-1">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="group" class="form-label">Gel. Pendaftaran</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" data-choices data-choices-search-false
                                            data-choices-sorting-false name="group" id="group">
                                            <option value="">Pilih Tahun Ajaran</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ select_old($group->id, old('group')) }}>
                                                    {{ $group->alias }}</option>
                                            @endforeach
                                        </select>
                                        @error('group')
                                            <div class="small text-danger mt-1">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="status" class="form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" data-choices data-choices-search-false
                                            data-choices-sorting-false name="status" id="status">
                                            <option value="">Pilih Status</option>
                                            <option value="1" {{ select_old('1', old('status')) }}>Alumni</option>
                                            <option value="0" {{ select_old('0', old('status')) }}>Belum Lulus
                                            </option>
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
                            </div>

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
