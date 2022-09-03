@extends('layouts.manage', ['title' => 'Wali Kelas'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.form_teacher.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Wali Kelas</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.form_teacher.store') }}" method="post">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="teacher" class="form-label">Guru</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" data-choices name="teacher" id="teacher">
                                    <option value="">Pilih Guru</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ select_old($teacher->id, old('teacher')) }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
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
