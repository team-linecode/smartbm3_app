@extends('layouts.manage', ['title' => 'Program Kerja'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <a href="{{ route('app.work_program_default.index') }}" class="btn btn-primary">
                        <i class="ri ri-arrow-left-line"></i>
                    </a>
                </div>
                <div>
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Proker Default</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('app.work_program_default.store') }}" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-4">
                                <label for="name" class="form-label">Penilaian</label>
                            </div>
                            <div class="col-sm-8">
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
                            <div class="col-sm-4">
                                <label for="success_indicator" class="form-label">Indikator Keberhasilan</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="success_indicator"
                                    class="form-control @error('success_indicator') is-invalid @enderror"
                                    id="success_indicator" value="{{ old('success_indicator') }}">
                                @error('success_indicator')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <h6 class="mt-4 mb-2 text-dark">Pilih Kriteria Penilaian</h6>
                        @if (session('alert-error'))
                            <div class="alert alert-danger">
                                {{ session('alert-error') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle w-100 mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th scope="col">No</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Kriteria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($value_criterias as $criteria)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input form-check-criteria" type="checkbox"
                                                        name="criterias[]" value="{{ $criteria->id }}" id="criteria{{ $criteria->id }}">
                                                    <label class="form-check-label"
                                                        for="criteria{{ $criteria->id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $criteria->category->name }}</td>
                                            <td>{{ $criteria->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- end table -->
                        </div>

                        <div class="row">
                            <div class="col-sm-9 mt-5">
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('include-script')
    <script>
        $("#checkAll").click(function() {
            $('.form-check-criteria').not(this).prop('checked', this.checked);
        });
    </script>
@endpush
