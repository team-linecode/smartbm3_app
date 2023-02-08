@extends('layouts.manage', ['title' => 'Laporan Piket'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-0">Laporan Piket Harian
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.picket_report.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="mb-3 mb-lg-0">
                                    <label for="date">Tanggal</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" id="date" value="{{ old('date') ?? date('Y-m-d') }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label class="d-none d-lg-block">&nbsp;</label>
                                <button name="export_as" value="pdf" class="btn btn-danger d-block w-100"><i
                                        class="ri-file-pdf-line align-middle"></i>&nbsp;Export&nbsp;PDF</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-0">Laporan Piket Bulanan
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.picket_report.export_monthly') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-lg-0">
                                            <label for="date">Bulan</label>
                                            <input type="month" class="form-control @error('date') is-invalid @enderror"
                                                name="date" id="date" value="{{ old('date') ?? date('Y-m') }}">
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-lg-0">
                                            <label for="classroom">Kelas</label>
                                            <select class="form-select @error('classroom') is-invalid @enderror" name="classroom" id="classroom">
                                                <option value="" hidden>Pilih Kelas</option>
                                                @foreach($classrooms as $classroom)
                                                    <option value="{{ $classroom->id }}" {{ select_old($classroom->id, old('classroom')) }}>{{ $classroom->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('classroom')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label class="d-none d-lg-block">&nbsp;</label>
                                <button name="export_as" value="pdf" class="btn btn-danger d-block w-100"><i
                                        class="ri-file-pdf-line align-middle"></i>&nbsp;Export&nbsp;PDF</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
