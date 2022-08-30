@extends('layouts.manage', ['title' => 'Edit Siswa'])

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
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Siswa</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.student.update', $student->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="name" class="form-label">Nama</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            value="{{ old('name') ?? $student->name }}">
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
                                            value="{{ old('nisn') ?? $student->nisn }}">
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
                                            value="{{ old('username') ?? $student->username }}">
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
                                            value="{{ old('email') ?? $student->email }}">
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
                                        <a href="" class="btn btn-primary"><i
                                                class="ri ri-lock-line align-bottom"></i> Ganti Password</a>
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
                                                    {{ select_old($classroom->id, old('classroom'), true, $student->classroom_id) }}>
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
                                                    {{ select_old($expertise->id, old('expertise'), true, $student->expertise_id) }}>
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
                                                    {{ select_old($schoolyear->id, old('schoolyear'), true, $student->schoolyear_id) }}>
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
                                                    {{ select_old($group->id, old('group'), true, $student->group_id) }}>
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
                                            <option value="1"
                                                {{ select_old('1', old('status'), true, $student->alumni) }}>Alumni
                                            </option>
                                            <option value="0"
                                                {{ select_old('0', old('status'), true, $student->alumni) }}>Belum Lulus
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="small text-danger mt-1">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
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

                                        @if ($student->image != null)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-lg mt-3">
                                                    <img src="{{ Storage::url($student->image) }}" alt="user-img"
                                                        class="img-thumbnail rounded-circle"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                </div>
                                                <a href="{{ route('app.student.destroy_image', $student->id) }}"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Hapus foto untuk siswa ini?')">
                                                    <i class="ri ri-delete-bin-line align-bottom"></i> Hapus Foto
                                                </a>
                                            </div>
                                        @endif
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
