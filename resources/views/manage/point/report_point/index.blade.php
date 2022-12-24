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
                        <input type="date" class="form-control" name="from_date" id="from_date">
                    </div>
                    <div class="col-lg-3">
                        <label for="to_date">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="to_date" id="to_date">
                    </div>
                    <div class="col-lg-3">
                        <label for="type">Tipe Poin</label>
                        <select class="form-select" name="type" id="type">
                            <option value="" hidden>Pilih Tipe</option>
                            <option value="all">Semua</option>
                            <option value="plus">Plus</option>
                            <option value="minus">Minus</option>
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
                        <select class="form-select select2" name="classrooms[]" id="classrooms" multiple data-placeholder="Pilih Kelas">
                            <option value="" hidden>Pilih Kelas</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="expertises">Jurusan</label>
                        <select class="form-select select2" name="expertises[]" id="expertises" multiple data-placeholder="Pilih Jurusan">
                            <option value="" hidden>Pilih Kelas</option>
                            @foreach ($expertises as $expertise)
                                <option value="{{ $expertise->id }}">{{ $expertise->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="from_date">Dari Tanggal</label>
                        <input type="date" class="form-control" name="from_date" id="from_date">
                    </div>
                    <div class="col-lg-3">
                        <label for="to_date">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="to_date" id="to_date">
                    </div>
                    <div class="col-lg-2 align-self-end">
                        <button class="btn btn-success w-100"><i class="ri-file-excel-2-line align-middle"></i> Export
                            Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
