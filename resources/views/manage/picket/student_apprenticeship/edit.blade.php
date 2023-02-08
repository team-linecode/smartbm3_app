@extends('layouts.manage', ['title' => 'Siswa PKL'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.student_apprenticeship.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Siswa PKL</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.student_apprenticeship.update', $student_apprenticeship->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="user" class="form-label">Siswa/i</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control select2 @error('user') is-invalid @enderror" name="user"
                                    id="user">
                                    <option value="" hidden>Pilih Siswa/i</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ select_old($user->id, old('user'), true, $student_apprenticeship->user_id) }}>
                                            {{ $user->name }} -> {{ $user->myClass() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    name="start_date" id="start_date" value="{{ old('start_date') ?? $student_apprenticeship->start_date }}">
                                @error('start_date')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    name="end_date" id="end_date" value="{{ old('end_date') ?? $student_apprenticeship->end_date }}">
                                @error('end_date')
                                    <div class="small text-danger mt-1">
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

@push('include-script')
    <script>
        $('#start_date').change(function() {
            let start_date = $(this).val()

            $('#end_date').attr('min', start_date)
        })

        $('#end_date').change(function() {
            let end_date = $(this).val()

            $('#start_date').attr('max', end_date)
        })
    </script>
@endpush
