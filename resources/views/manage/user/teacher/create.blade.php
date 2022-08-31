@extends('layouts.manage', ['title' => 'Tambah Guru'])

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
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Guru</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form action="{{ route('app.teacher.store') }}" method="post" enctype="multipart/form-data">
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
                                        <input type="text" name="nip"
                                            class="form-control @error('nip') is-invalid @enderror" id="nip"
                                            value="{{ old('nip') }}">
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

                                <div class="col-sm-9 offset-lg-3 mb-3">
                                    <button class="btn btn-primary ms-1">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <h6>Mata pelajaran yang diampuh</h6>
                            <form action="{{ route('app.teacher.create_lesson_sess') }}" method="post">
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

                            @if (session('lesson_teacher'))
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
                                            @foreach (session('lesson_teacher') as $id => $lesson_teacher)
                                                @php($total += $lesson_teacher['hours'])
                                                <tr>
                                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                                    <td class="align-middle">{{ $lesson_teacher['lesson_name'] }}</td>
                                                    <td class="align-middle">{{ $lesson_teacher['hours'] }} Jam</td>
                                                    <td class="text-end">
                                                        <div class="remove">
                                                            <form
                                                                action="{{ route('app.teacher.destroy_lesson_sess', $id) }}"
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
                                                    <form action="{{ route('app.teacher.destroy_all_lesson_sess') }}"
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
