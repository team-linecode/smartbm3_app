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
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Prestasi</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.achievement.update', $achievement->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Wali Kelas</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select" name="teacher" id="teacher"
                                    {{ in_array(auth()->user()->id, $teachers->pluck('id')->toArray()) ? 'disabled' : '' }}>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ select_old($teacher->id, old('teacher'), true, $achievement->teacher_id) }}
                                            {{ $teacher->id == auth()->user()->id ? 'selected' : '' }}>{{ $teacher->name }}
                                        </option>
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
                                        <option value="{{ $student->id }}"
                                            {{ select_old($student->id, old('student'), true, $achievement->student_id) }}
                                            {{ $student->id == auth()->user()->id ? 'selected' : '' }}>
                                            {{ $student->name }} - {{ $student->myClass() }}</option>
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
                                    value="{{ old('name') ?? $achievement->name }}">
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
                                    value="{{ old('champion') ?? $achievement->champion }}">
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
                                    value="{{ old('level') ?? $achievement->level }}">
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
                                    value="{{ date('Y-m-d', strtotime($achievement->date)) }}">
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
                                <textarea rows="3" name="description" class="form-control @error('description') is-invalid @enderror"
                                    id="description">{{ old('description') ?? $achievement->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
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

                                <div class="mt-3">
                                    <div class="d-flex flex-wrap">
                                        @foreach ($achievement->attachments as $attachment)
                                            <div style="width: calc(100%/3); padding-right: 10px;">
                                                <a href="{{ Storage::url($attachment->file) }}">
                                                    <div class="card">
                                                        @if (in_array($attachment->format, ['png', 'jpg', 'jpeg']))
                                                            <img src="{{ Storage::url($attachment->file) }}"
                                                                class="img-fluid">
                                                        @endif
                                                        <div class="card-body p-2">
                                                            @php($explode = explode('/', $attachment->file))
                                                            <small class="d-block fw-bold">{{ Str::limit(end($explode), 10) }}</small>
                                                            <small class="d-block fw-bold text-success">{{ $attachment->format }}</small>
                                                            <small class="d-block text-secondary mb-2">{{ number_format(ceil($attachment->size/1024)) }} MB</small>
                                                            <a href="{{ route('app.achievement.attachment.destroy', $attachment->id) }}" target="_blank" onclick="return confirm('Ingin menghapus lampiran?')" class="btn btn-sm btn-danger w-100">Hapus</a>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
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
