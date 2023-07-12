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
                            <div class="col-sm-5">
                                <label for="name" class="form-label text-muted">NAMA KARYAWAN YANG DINILAI</label>
                            </div>
                            <div class="col-sm-7">
                                <div class="mb-1">{{ $user->name }}</div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-5">
                                <label for="name" class="form-label text-muted">JABATAN YANG DINILAI</label>
                            </div>
                            <div class="col-sm-7">
                                <div class="mb-1">{{ $user->position->name ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-5">
                                <label for="name" class="form-label text-muted">NO INDUK KARYAWAN</label>
                            </div>
                            <div class="col-sm-7">
                                <div class="mb-1">{{ $user->nip ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-5">
                                <label for="name" class="form-label text-muted">BAGIAN</label>
                            </div>
                            <div class="col-sm-7">
                                <div class="mb-1">{{ $user->position->name ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-5">
                                <label for="name" class="form-label text-muted">PENILAI</label>
                            </div>
                            <div class="col-sm-7">
                                <select class="form-select select2" name="pic" id="pic">
                                    <option value="">Pilih Penilai</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
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
