@extends('layouts.manage', ['title' => 'Member'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.loan_member.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Member</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.loan_member.store') }}" method="post">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="classroom" class="form-label">Kelas</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('classroom') is-invalid @enderror"
                                    name="classroom" id="classroom">
                                    <option value="" hidden>Pilih Kelas</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}"
                                            {{ select_old($classroom->id, old('classroom')) }}>
                                            {{ $classroom->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classroom')
                                    <div class="invalid-feedback">
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
                                <select class="form-select @error('expertise') is-invalid @enderror"
                                    name="expertise" id="expertise">
                                    <option value="" hidden>Pilih Jurusan</option>
                                    @foreach ($expertises as $expertise)
                                        <option value="{{ $expertise->id }}"
                                            {{ select_old($expertise->id, old('expertise')) }}>
                                            {{ $expertise->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('expertise')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-primary">Simpan</button>
                                    <div class="form-check ms-3">
                                        <input class="form-check-input" name="stay" type="checkbox" id="checkboxStay">
                                        <label class="form-check-label" for="checkboxStay">
                                            Tetap dihalaman ini
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
