@extends('layouts.manage', ['title' => 'Laporan Poin'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-center text-lg-start text-uppercase mb-0">Laporan Detail Poin Siswa
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('app.point.export_point') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <label for="from_date">Dari Tanggal</label>
                        <input type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date"
                            id="from_date" value="{{ old('from_date') }}">
                    </div>
                    <div class="col-lg-3">
                        <label for="to_date">Sampai Tanggal</label>
                        <input type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date"
                            id="to_date" value="{{ old('to_date') }}">
                    </div>
                    <div class="col-lg-3">
                        <label for="type">Tipe Poin</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="type">
                            <option value="" hidden>Pilih Tipe</option>
                            <option value="all" {{ select_old('all', old('type')) }}>Semua Poin</option>
                            <option value="plus" {{ select_old('plus', old('type')) }}>Poin Plus</option>
                            <option value="minus" {{ select_old('minus', old('type')) }}>Poin Minus</option>
                        </select>
                    </div>
                    <div class="col-lg-3 align-self-end">
                        <button class="btn btn-success w-100"><i class="ri-file-excel-2-line align-middle"></i> Export
                            Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-center text-lg-start text-uppercase mb-0">Laporan Total Point Siswa
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('app.point.export_total_point') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-2">
                        <label for="classrooms">Kelas</label>
                        <select class="form-select select2 @error('classrooms') is-invalid @enderror" name="classrooms[]" id="classrooms" multiple
                            data-placeholder="Pilih Kelas">
                            <option value="" hidden>Pilih Kelas</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="expertises">Jurusan</label>
                        <select class="form-select select2 @error('expertises') is-invalid @enderror" name="expertises[]" id="expertises" multiple
                            data-placeholder="Pilih Jurusan">
                            <option value="" hidden>Pilih Kelas</option>
                            @foreach ($expertises as $expertise)
                                <option value="{{ $expertise->id }}">{{ $expertise->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="from_date2">Dari Tanggal</label>
                        <input type="date" class="form-control @error('from_date2') is-invalid @enderror" name="from_date2" id="from_date2">
                    </div>
                    <div class="col-lg-3">
                        <label for="to_date2">Sampai Tanggal</label>
                        <input type="date" class="form-control @error('to_date2') is-invalid @enderror" name="to_date2" id="to_date2">
                    </div>
                    <div class="col-lg-2">
                        <label class="d-none d-md-block d-lg-block d-xl-block">&nbsp;</label>
                        <button class="btn btn-success w-100"><i class="ri-file-excel-2-line align-middle"></i> Export
                            Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('include-script')
    <script>
        $('#from_date').change(function() {
            let from_date = $(this).val()

            $('#to_date').attr('min', from_date)
        })

        $('#to_date').change(function() {
            let to_date = $(this).val()

            $('#from_date').attr('max', to_date)
        })
    </script>
@endpush
