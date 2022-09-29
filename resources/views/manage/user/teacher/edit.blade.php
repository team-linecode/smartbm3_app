@extends('layouts.manage', ['title' => 'Edit Guru'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.teacher.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Guru</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form action="{{ route('app.teacher.update', $teacher->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="name" class="form-label">Nama</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            value="{{ old('name') ?? $teacher->name }}">
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
                                        <input type="text" name="nip"
                                            class="form-control @error('nip') is-invalid @enderror" id="nip"
                                            value="{{ old('nip') ?? $teacher->nip }}">
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
                                            value="{{ old('username') ?? $teacher->username }}">
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
                                            value="{{ old('email') ?? $teacher->email }}">
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
                                        <a href="{{ route('app.teacher.change_password', $teacher->id) }}" class="btn btn-primary"><i
                                                class="ri ri-lock-line align-bottom"></i> Ganti Password</a>
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

                                        @if ($teacher->image != null)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-lg mt-3">
                                                    <img src="{{ Storage::url($teacher->image) }}" alt="user-img"
                                                        class="img-thumbnail rounded-circle"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                </div>
                                                <a href="{{ route('app.teacher.destroy_image', $teacher->id) }}"
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
                        <div class="col-lg-6">
                            <h6>Mata pelajaran yang diampuh</h6>
                            <form action="{{ route('app.teacher.create_lesson', $teacher->id) }}" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-6 col-lg-5">
                                        <div class="mb-3">
                                            <select class="form-control" data-choices name="lesson" id="lesson">
                                                <option value="">Mata Pelajaran</option>
                                                @foreach ($lessons as $lesson)
                                                    <option value="{{ $lesson->id }}"
                                                        {{ select_old($lesson->id, old('lesson')) }}>
                                                        {{ $lesson->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('lesson')
                                                <div class="small text-danger mt-1">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-5">
                                        <div class="mb-3">
                                            <input type="number" name="hours"
                                                class="form-control @error('hours') is-invalid @enderror" id="hours"
                                                placeholder="Jumlah Jam">
                                            @error('hours')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-primary w-100">Add</button>
                                    </div>
                                </div>
                            </form>

                            @if (count($teacher->lessons) > 0)
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Mapel</th>
                                                <th scope="col">Jumlah Jam</th>
                                                <th scope="col" class="text-end">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($total = 0)
                                            @foreach ($teacher->lessons as $lesson_teacher)
                                                @php($total += $lesson_teacher->pivot->hours)
                                                <tr>
                                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                                    <td class="align-middle">{{ $lesson_teacher->name }}</td>
                                                    <td class="align-middle">{{ $lesson_teacher->pivot->hours }} Jam</td>
                                                    <td class="text-end">
                                                        <div class="remove">
                                                            <form
                                                                action="{{ route('app.teacher.destroy_lesson', [$teacher->id, $lesson_teacher->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm c-delete"><i
                                                                        class="ri ri-delete-bin-line"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td></td>
                                                <td class="text-end fw-bold">Total :</td>
                                                <td>{{ $total }} Jam</td>
                                                <td class="text-end">
                                                    <form
                                                        action="{{ route('app.teacher.destroy_all_lesson', $teacher->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm c-delete">
                                                            Hapus Semua
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop