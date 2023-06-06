@extends('layouts.manage', ['title' => 'Prestasi'])

@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.achievement.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Prestasi</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.achievement.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Wali Kelas</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select" name="teacher" id="teacher" {{ in_array(auth()->user()->id, $teachers->pluck('id')->toArray()) ? 'disabled' : '' }}>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ select_old($teacher->id, old('teacher')) }} {{ $teacher->id == auth()->user()->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                @error('teacher')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-start mb-3">
                            <div class="col-sm-3">
                                <label for="student" class="form-label">Siswa/i</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select select2" name="student" id="student">
                                    <option value="" hidden>Pilih Siswa/i</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" {{ select_old($student->id, old('student')) }} {{ $student->id == auth()->user()->id ? 'selected' : '' }}>{{ $student->name }} - {{ $student->myClass() }}</option>
                                    @endforeach
                                </select>
                                @error('students')
                                    <div class="small text-danger">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Nama Kegiatan</label>
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
                                <label for="champion" class="form-label">Juara</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="champion"
                                    class="form-control @error('champion') is-invalid @enderror" id="champion"
                                    value="{{ old('champion') }}">
                                @error('champion')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="level" class="form-label">Tingkat</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="level"
                                    class="form-control @error('level') is-invalid @enderror" id="level"
                                    value="{{ old('level') }}">
                                @error('level')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="date" class="form-label">Tanggal</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="date" name="date"
                                    class="form-control @error('date') is-invalid @enderror" id="date"
                                    value="{{ old('date') ?? date('Y-m-d') }}">
                                @error('date')
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
                                <textarea rows="3" name="description"
                                    class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="attachment" class="form-label">Lampiran</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="file" name="attachment[]"
                                    class="form-control @error('attachment') is-invalid @enderror" id="attachment"
                                    value="{{ old('attachment') }}" multiple>
                                @error('attachment')
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
