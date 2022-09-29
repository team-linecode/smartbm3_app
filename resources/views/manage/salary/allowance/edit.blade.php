@extends('layouts.manage', ['title' => 'Data Tunjangan'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.allowance.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Tunjangan</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.allowance.store') }}" method="post">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Tunjangan</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') ?? $allowance->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label class="form-label">Kriteria Tunjangan</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <button type="button"
                                        class="btn btn-primary remove-input {{ session('input_session')['number'] <= 1 ? 'disabled' : '' }}">
                                        <i class="ri ri-subtract-line align-middle"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary add-input">
                                        <i class="ri ri-add-line align-middle"></i>
                                    </button>
                                    <button type="button" class="btn btn-light" disabled>
                                        {{ session('input_session')['number'] }}
                                    </button>
                                    <button type="button" class="btn btn-danger reset-input">Reset</button>
                                </div>

                                <h2>Add More</h2>

                                @for ($i = 0; $i < session('input_session')['number']; $i++)
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-lg-4 mb-3 mb-md-0 mb-lg-0">
                                                    <label for="description" class="form-label">Keterangan</label>
                                                    <input type="text" name="description[]"
                                                        class="form-control @error('description.' . $i) is-invalid @enderror"
                                                        id="description" value="{{ old('description.' . $i) }}">
                                                    @error('description.' . $i)
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3 mb-md-0 mb-lg-0">
                                                    <label for="last_education" class="form-label">Pend. Terakhir</label>
                                                    <select class="form-select" name="last_education[]" id="last_education">
                                                        <option value="">Tanpa Pend. Terakhir</option>
                                                        @foreach ($last_educations as $last_education)
                                                            <option value="{{ $last_education->id }}"
                                                                {{ select_old_multiple($last_education->id, old('last_education.' . $i)) }}>
                                                                {{ $last_education->alias }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('last_education.' . $i)
                                                        <div class="small text-danger mt-1">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 mb-3 mb-md-0 mb-lg-0">
                                                    <label for="salary" class="form-label">Gaji</label>
                                                    <input type="text" name="salary[]"
                                                        class="form-control currency @error('salary.' . $i) is-invalid @enderror"
                                                        id="salary" value="{{ old('salary.' . $i) }}">
                                                    @error('salary.' . $i)
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor

                                <h2>Current Data</h2>

                                @foreach ($allowance->details as $i => $detail)
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="row mb-3 align-items-end">
                                                <div class="col-lg-4 mb-3 mb-md-0 mb-lg-0">
                                                    <label for="description" class="form-label">Keterangan</label>
                                                    <input type="text" name="description[]"
                                                        class="form-control @error('description.' . $i) is-invalid @enderror"
                                                        id="description"
                                                        value="{{ old('description.*') ?? $detail->description }}">
                                                    @error('description.' . $i)
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3 mb-3 mb-md-0 mb-lg-0">
                                                    <label for="last_education" class="form-label">Pend. Terakhir</label>
                                                    <select class="form-select" name="last_education[]" id="last_education">
                                                        <option value="">Tanpa Pend. Terakhir</option>
                                                        @foreach ($last_educations as $last_education)
                                                            <option value="{{ $last_education->id }}"
                                                                {{ select_old_multiple($last_education->id, old('last_education.' . $i), true, $detail->last_education_id) }}>
                                                                {{ $last_education->alias }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('last_education.' . $i)
                                                        <div class="small text-danger mt-1">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3 mb-3 mb-md-0 mb-lg-0">
                                                    <label for="salary" class="form-label">Gaji</label>
                                                    <input type="text" name="salary[]"
                                                    class="form-control currency @error('salary.' . $i) is-invalid @enderror"
                                                    id="salary"
                                                    value="{{ old('salary.*') ?? number_format($detail->salary) }}">
                                                    @error('salary.' . $i)
                                                    <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-2 mb-3 mb-md-0 mb-lg-0">
                                                    <form action="" method="">
                                                        <button class="btn btn-danger"><i
                                                                class="ri ri-delete-bin-line"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
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

@push('include-script')
    <script>
        $('.add-input').click(function() {
            $.ajax({
                url: "{{ route('app.salary.allowance.add_input') }}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.status == 200) {
                        location.reload();
                    } else if (result.status == 500) {
                        Toast.fire({
                            icon: 'error',
                            title: "Batas Maksimal"
                        })
                    }
                }
            });
        });

        $('.remove-input').click(function() {
            $.ajax({
                url: "{{ route('app.salary.allowance.remove_input') }}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.status == 200) {
                        location.reload();
                    } else if (result.status == 500) {
                        Toast.fire({
                            icon: 'error',
                            title: "Batas Minimal"
                        })
                    }
                }
            });
        });

        $('.reset-input').click(function() {
            $.ajax({
                url: "{{ route('app.salary.allowance.reset_input') }}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    location.reload();
                }
            });
        });
    </script>
@endpush
