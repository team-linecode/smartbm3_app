@extends('layouts.manage', ['title' => 'Ubah Penggajian'])

@section('content')
    <form action="{{ route('app.salaries.update', $salary->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Bulan</label>
                                    <input type="month" class="form-control @error('month') is-invalid @enderror"
                                        name="month" id="date" value="{{ old('month') ?? $salary->month }}">
                                    @error('month')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="Status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status"
                                        id="Status">
                                        <option value="" hidden>Pilih Status</option>
                                        <option value="open"
                                            {{ select_old('open', old('status'), true, $salary->status) }}>Dibuka</option>
                                        <option value="close"
                                            {{ select_old('close', old('status'), true, $salary->status) }}>Ditutup</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                Klik "<b>Generate</b>" untuk membuat penggajian
                            </div>
                            <div>
                                <button class="btn btn-primary">Re-Generate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="mt-2 mb-3 mx-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="UserCheckAll"
                                    onclick="userCheckAll(this)">
                                <label class="form-check-label" for="UserCheckAll">
                                    <h6 class="fw-bold mb-0">Pilih Semua</h6>
                                </label>
                            </div>
                        </div>

                        @forelse ($salaryDetails as $indexDetail => $detail)
                            {{-- {{ dd(getFormula('[TJJBTN]', $detail->user->id)) }} --}}
                            <div class="card shadow-none border-1 mb-2">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            {{-- checkbox user --}}
                                            <div class="form-check">
                                                <input class="form-check-input user-checkbox" type="checkbox" name="users[]"
                                                    value="{{ $detail->user->id }}" id="userCheck{{ $indexDetail }}">
                                                <label class="form-check-label" for="userCheck{{ $indexDetail }}">
                                                    <h6 class="fw-bold">{{ $detail->user->name }}</h6>
                                                    <table class="text-primary">
                                                        <tr valign="top">
                                                            <td>Level</td>
                                                            <td class="px-2">:</td>
                                                            <td>{{ strtoupper($detail->user->getRoleNames()->implode(', ')) }}</td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td>Jabatan</td>
                                                            <td class="px-2">:</td>
                                                            <td>{{ $detail->user->positions()->exists() ? $detail->user->positions->pluck('name')->implode(', ') : 'Guru' }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </label>
                                            </div>
                                            {{-- end checkbox user --}}
                                        </div>
                                        <div>
                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseSalary{{ $indexDetail }}" aria-expanded="false"
                                                aria-controls="collapseSalary{{ $indexDetail }}">
                                                Rincian
                                            </button>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapseSalary{{ $indexDetail }}">
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h6 class="fw-bold">Penerimaan</h6>
                                                @php
                                                    $allowanceTotal = 0;
                                                @endphp
                                                @forelse (json_decode($detail->components, true)['allowances'] as $indexAllowance => $allowance)
                                                    @php
                                                        $allowanceTotal += 0;
                                                    @endphp
                                                    <div class="card shadow-none border-1 mb-2">
                                                        <div class="card-body ps-2 pe-1 py-1">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-6">
                                                                    <h6 class="mb-2 mb-md-0 mb-lg-0 mb-xl-0">
                                                                        {{ $allowance['name'] }}</h6>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text fw-medium"
                                                                            id="basic-addon1">Rp.</span>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm currency"
                                                                            name="allowances[{{ $detail->user->id }}][{{ $allowance['name'] }}]"
                                                                            placeholder="Masukkan Jumlah"
                                                                            value="{{ number_format($allowance['amount']) }}">
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
                                                @forelse (json_decode($detail->components, true)['salary_cuts'] as $indexSalaryCut => $salary_cut)
                                                    <div class="card shadow-none border-1 mb-2">
                                                        <div class="card-body ps-2 pe-1 py-1">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-6">
                                                                    <h6 class="mb-0">{{ $salary_cut['name'] }}</h6>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text fw-medium"
                                                                            id="basic-addon1">Rp.</span>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm currency"
                                                                            placeholder="Masukkan Jumlah"
                                                                            name="salary_cuts[{{ $detail->user->id }}][{{ $salary_cut['name'] }}]"
                                                                            value="{{ number_format($salary_cut['amount']) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="card shadow-none border-1 text-center mb-0">
                                                        <div class="card-body px-2 py-1">
                                                            <div class="text-danger">Tidak ada data Potongan!</div>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="ps-3 text-danger mb-2"><i class="ri ri-information-line align-middle"></i> Tidak
                                ada Staff /
                                Guru
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@push('include-script')
    <script>
        function userCheckAll(source) {
            var checkboxes = document.querySelectorAll('.user-checkbox');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endpush
