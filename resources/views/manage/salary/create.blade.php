@extends('layouts.manage', ['title' => 'Penggajian'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-2">
                    @foreach ($users as $indexUser => $user)
                        <div class="card shadow-none border-1 mb-2">
                            <div class="card-body">
                                {{-- checkbox user --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="userCheck{{ $indexUser }}">
                                    <label class="form-check-label" for="userCheck{{ $indexUser }}">
                                        <h6 class="fw-bold">{{ $user->name }}</h6>
                                        <table class="text-primary">
                                            <tr valign="top">
                                                <td>Level</td>
                                                <td class="px-2">:</td>
                                                <td>{{ strtoupper($user->role->name) }}</td>
                                            </tr>
                                            <tr valign="top">
                                                <td>Jabatan</td>
                                                <td class="px-2">:</td>
                                                <td>{{ $user->positions()->exists() ? $user->positions->pluck('name')->implode(', ') : 'Guru' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </label>
                                </div>
                                {{-- end checkbox user --}}
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6 class="fw-bold">Penerimaan</h6>
                                        <div class="card shadow-none border-1 mb-2">
                                            <div class="card-body ps-2 pe-1 py-1">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6">
                                                        {{-- checkbox allowance --}}
                                                        <div class="form-check mb-2 mb-md-0 mb-lg-0 mb-xl-0">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="allowanceCheck{{ $indexUser }}0">
                                                            <label class="form-check-label"
                                                                for="allowanceCheck{{ $indexUser }}0">
                                                                <h6 class="mb-0">Gaji Pokok</h6>
                                                            </label>
                                                        </div>
                                                        {{-- end checkbox allowance --}}
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text fw-medium"
                                                                id="basic-addon1">Rp.</span>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Masukkan Jumlah">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @forelse ($allowances as $indexAllowance => $allowance)
                                            <div class="card shadow-none border-1 mb-2">
                                                <div class="card-body ps-2 pe-1 py-1">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-6">
                                                            {{-- checkbox allowance --}}
                                                            <div class="form-check mb-2 mb-md-0 mb-lg-0 mb-xl-0">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value=""
                                                                    id="allowanceCheck{{ $indexUser }}{{ $indexAllowance++ }}">
                                                                <label class="form-check-label"
                                                                    for="allowanceCheck{{ $indexUser }}{{ $indexAllowance++ }}">
                                                                    <h6 class="mb-0">{{ $allowance->name }}</h6>
                                                                </label>
                                                            </div>
                                                            {{-- end checkbox allowance --}}
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group">
                                                                <span class="input-group-text fw-medium"
                                                                    id="basic-addon1">Rp.</span>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Masukkan Jumlah">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="card shadow-none border-1 text-center mb-0">
                                                <div class="card-body px-2 py-1">
                                                    <div class="text-danger">Tidak ada data Tunjangan!</div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="col-lg-6">
                                        <h6 class="fw-bold">Pemotongan</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
