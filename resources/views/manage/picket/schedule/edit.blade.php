@extends('layouts.manage', ['title' => 'Jadwal Piket'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.picket_schedule.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Jadwal Piket</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.picket_schedule.update', $picket_schedule->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="hari" class="form-label">Hari</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" name="day" id="day">
                                    <option value="" hidden>Pilih Hari</option>
                                    @foreach ($days as $day)
                                        <option value="{{ $day->id }}" {{ select_old($day->id, old('day'), true, $picket_schedule->day_id) }}>
                                            {{ $day->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('day')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="users" class="form-label">Staff/Guru</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="users[]" id="users" data-placeholder="Pilih Staff/Guru" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ select_old_multiple($user->id, old('users'), true, $picket_schedule->users->pluck('id')->toArray()) }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('users')
                                    <div class="small text-danger mt-1">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
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
