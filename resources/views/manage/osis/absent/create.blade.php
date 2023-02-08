@extends('layouts.manage', ['title' => 'Input Absen'])

@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.absent.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Input Absen
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('component.default-alert')

                    <form action="{{ route('app.absent.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="penalty_point" value="{{ $penalty_point->id }}">
                        <input type="hidden" name="type" value="plus">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="penalty_point" class="form-label">Pelanggaran</label>
                            </div>
                            <div class="col-sm-9">
                                <ul style="list-style-type:'[{{ $penalty_point->code }}] '">
                                    <li>{{ $penalty_point->name }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="users" class="form-label">Siswa/i</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select select2 @error('users') is-invalid @enderror" name="users[]"
                                    id="users" multiple data-placeholder="Pilih Siswa/i">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ select_old_multiple($user->id, old('users')) }}>{{ $user->name }} ->
                                            {!! $user->myClass() !!}
                                        </option>
                                    @endforeach
                                </select>
                                @error('users')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="date" class="form-label">Tanggal & Waktu</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="datetime-local" name="date"
                                    class="form-control @error('date') is-invalid @enderror" id="date"
                                    value="{{ old('date') ?? date('Y-m-d\TH:i') }}">
                                @error('date')
                                    <div class="invalid-feedback">
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
