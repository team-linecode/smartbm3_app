@extends('layouts.manage', ['title' => 'Program Kerja'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.value_criteria.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Ubah Kriteria</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.value_criteria.update', $value_criteria->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="category" class="form-label">Kategori Proker</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select select2 @error('category') is-invalid @enderror" name="category"
                                    id="category">
                                    <option value="">Pilih Kategori Proker</option>
                                    @foreach ($work_program_categories as $wp_category)
                                        <option value="{{ $wp_category->id }}"
                                            {{ select_old($wp_category->id, $value_criteria->category->id) }}>
                                            {{ $wp_category->name }}
                                            ({{ $wp_category->percentage }}%)
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Kriteria</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') ?? $value_criteria->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="status" class="form-label"></label>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio"
                                        name="status" id="status-y" value="active"
                                        {{ cb_old('active', [$value_criteria->status]) }}>
                                    <label class="form-check-label" for="status-y">
                                        Gunakan Kriteria Ini
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio"
                                        name="status" id="status-n" value="nonactive"
                                        {{ cb_old('nonactive', [$value_criteria->status]) }}>
                                    <label class="form-check-label" for="status-n">
                                        Gunakan Nanti
                                    </label>
                                </div>
                                @error('status')
                                    <div class="small text-danger pt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
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
