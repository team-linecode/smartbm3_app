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
                        <h4 class="card-title text-center text-uppercase mb-0">Tambah Guru</h4>
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
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}">
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
                                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" id="nip" value="{{ old('nip') }}">
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
                                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}">
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
                                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}">
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
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
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
                                            <input type="password" name="re-password" class="form-control @error('re-password') is-invalid @enderror" id="re-password">
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
                                    <label for="roles" class="form-label">Roles</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-select select2 @error('roles') is-invalid @enderror" name="roles[]" id="roles" multiple data-placeholder="Pilih Role">
                                        <option value="">Pilih Role</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ select_old_multiple($role->id, old('roles')) }}>
                                            {{ $role->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                    <div class="invalid-feedback">
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
                                    <select class="form-select @error('re-password') is-invalid @enderror" name="last_education" id="last_education">
                                        <option value="">Pend. Terakhir</option>
                                        @foreach ($last_educations as $last_education)
                                        <option value="{{ $last_education->id }}" {{ select_old($last_education->id, old('last_education')) }}>
                                            {{ $last_education->name }} | {{ $last_education->alias }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('last_education')
                                    <div class="invalid-feedback">
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
                                        <input type="date" name="entry_date" class="form-control entry_date @error('entry_date') is-invalid @enderror" id="entry_date" value="{{ old('entry_date') }}">
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
                                    <select class="form-select @error('status') is-invalid @enderror" name="status" id="Status">
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
                                    <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender">
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
                                    <select class="form-select @error('marital_status') is-invalid @enderror" name="marital_status" id="marital_status">
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
                                    <input type="text" name="child" class="form-control @error('child') is-invalid @enderror" id="child" value="{{ old('child') ?? 0 }}">
                                    @error('child')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-sm-3">
                                    <label for="is_hometeacher" class="form-label">Wali Kelas</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-select @error('is_hometeacher') is-invalid @enderror" name="is_hometeacher" id="is_hometeacher">
                                        <option value="0" {{ select_old('0', old('is_hometeacher')) }}>Bukan Wali Kelas</option>
                                        <option value="1" {{ select_old('1', old('is_hometeacher')) }}>Wali Kelas</option>
                                    </select>
                                    @error('is_hometeacher')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center mb-3 d-none" id="inputClassroom">
                                <div class="col-sm-3">
                                    <label for="classroom" class="form-label">Kelas & Jurusan</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <select class="form-select @error('classroom') is-invalid @enderror" name="classroom" id="classroom">
                                                <option value="" hidden>Pilih Kelas</option>
                                                @foreach ($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}" {{ select_old($classroom->id, old('classroom')) }}>{{ $classroom->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('classroom')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <select class="form-select @error('expertise') is-invalid @enderror" name="expertise" id="expertise">
                                                <option value="" hidden>Pilih Jurusan</option>
                                                @foreach ($expertises as $expertise)
                                                <option value="{{ $expertise->id }}" {{ select_old($expertise->id, old('expertise')) }}>{{ $expertise->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('expertise')
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
                                    <input type="file" class="form-control" name="picture" accept="image/png, image/jpeg, image/gif" />
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
                                        <select class="form-select" name="lesson" id="lesson">
                                            <option value="">Mata Pelajaran</option>
                                            @foreach ($lessons as $lesson)
                                            <option value="{{ $lesson->id }}" {{ select_old($lesson->id, old('lesson')) }}>
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
                                        <input type="number" name="hours" class="form-control @error('hours') is-invalid @enderror" id="hours" placeholder="Jumlah Jam">
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
                                                <form action="{{ route('app.teacher.destroy_lesson_sess', $id) }}" method="post">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger btn-sm c-delete">
                                                        <i class="ri ri-delete-bin-line"></i>
                                                    </button>
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
                                            <form action="{{ route('app.teacher.destroy_all_lesson_sess') }}" method="post">
                                                @csrf
                                                <button type="button" class="btn btn-outline-danger btn-sm c-delete">
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

@push('include-script')
<script>
    function toggleClassroom(toggle) {
        if (toggle == 'show') {
            $('#inputClassroom').removeClass('d-none')
        } else if (toggle == 'hide') {
            $('#inputClassroom').addClass('d-none')
        }
    }

    $('#is_hometeacher').change(function() {
        let val = $(this).val()

        if (val == 0) {
            toggleClassroom('hide')
        } else {
            toggleClassroom('show')
        }
    })
</script>

@if (old('is_hometeacher'))
<script>
    toggleClassroom('show')
</script>
@endif
@endpush
