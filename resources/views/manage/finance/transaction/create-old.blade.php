@extends('layouts.manage', ['title' => 'Transaksi'])

@section('content')
    <form action="{{ route('app.finance.transaction.save_transaction') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-body bg-light py-3">
                <h5 class="mb-0">Data Siswa</h5>
            </div>
            <div class="card-body border-bottom border-bottom-0 p-4">
                <div class="row gy-3">
                    <div class="col-lg-8 order-1 order-md-0 order-lg-0">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label">Nama Siswa</label>
                            </div>
                            <div class="col-lg-9">
                                <p id="displayName">___</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label">NIS/NISN</label>
                            </div>
                            <div class="col-lg-9">
                                <p id="displayNis">___</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label">Kelas</label>
                            </div>
                            <div class="col-lg-9">
                                <p id="displayClass">___</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label mb-0">Jurusan</label>
                            </div>
                            <div class="col-lg-9">
                                <p id="displayExpertise">___</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="form-label mb-0">Tahun Ajaran</label>
                            </div>
                            <div class="col-lg-9">
                                <p class="mb-0" id="displaySchoolyear">___</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">Pilih Siswa/i</label>
                        <select name="user_id" class="form-select select2 w-100" id="user">
                            <option value="">- Pilih Siswa/i -</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ select_old($user->id, old('user_id')) }}>
                                    {{ $user->name }} [{{ $user->myClass() }}]
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light py-3">
                <h5 class="mb-0">Item Transaksi</h5>
            </div>
            <div class="card-body">
                <div id="form-group">
                    <div class="form-input">
                        <div class="row align-items-end mb-4">
                            <div class="col-lg-3">
                                <div class="mb-3 mb-md-0">
                                    <label for="cost_id" class="form-label">Biaya</label>
                                    <select class="form-select selectCost" name="cost_ids[]" id="selectCost" required>
                                        <option selected>Pilih Biaya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 mb-md-0">
                                    <label for="cost_detail_id" class="form-label">Detail</label>
                                    <select class="form-select selectCostDetail" name="cost_detail_ids[]" id="selectCostDetail"
                                        disabled>
                                        <option selected>Pilih satu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3 mb-md-0">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="dates[]" id="date" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3 mb-md-0">
                                    <label for="amount" class="form-label">Jumlah (Rp)</label>
                                    <input type="text" class="form-control currency amount" name="amounts[]" id="amount" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="d-flex no-wrap">
                                    <button type="button" class="btn btn-danger m3-1 btn-remove"><i
                                            class="bx bx-trash"></i></button>
                                    <button type="button" class="btn btn-success mx-1 btn-move-up"><i
                                            class="bx bx-up-arrow-alt"></i></button>
                                    <button type="button" class="btn btn-warning btn-move-down"><i
                                            class="bx bx-down-arrow-alt"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom mb-3"></div>
                    </div>
                    <button type="button" class="btn btn-primary" id="btn-add">Tambah</button>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-lg-3 col-sm-6">
                        <label for="invoice_id">Invoice ID</label>
                        <input type="text" class="form-control bg-light border-0" name="invoice_id" id="invoice_id"
                            value="#BMM{{ rand(100000, 999999) }}" readonly="readonly" />
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label for="date-field">Tanggal Transaksi</label>
                        <input type="text" class="form-control bg-light border-0 @error('date') is-invalid @enderror"
                            name="date" id="date-field" data-provider="flatpickr" data-date-format="Y-m-d"
                            data-enable-time placeholder="Pilih Tanggal">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6 col-sm-6 text-end align-self-end">
                        <button class="btn btn-primary" id="btnNext">Simpan</button>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </form>
@stop

@push('include-script')
    @include('component.loading')
    @include('manage.finance.transaction.component.form')

    @if ($errors->has('date'))
        <script>
            getDetailUser("{{ route('app.finance.transaction.get_user') }}", {
                _token: "{{ csrf_token() }}",
                user_id: $('#user').val()
            })
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('#user').change(function() {
                let val = $(this).val()

                if (val != '') {
                    getDetailUser("{{ route('app.finance.transaction.get_user') }}", {
                        _token: "{{ csrf_token() }}",
                        user_id: val,
                    })
                } else {
                    $('#btnNext').addClass('disabled')
                    $('#displayName').html('___')
                    $('#displayNis').html('___')
                    $('#displayClass').html('___')
                    $('#displayExpertise').html('___')
                    $('#displaySchoolyear').html('___')
                }
            })

            $('#form-group').on("change", ".selectCost", function() {
                // console.log($(this).parent().parent().next().html())
                getCostDetail($(this), "{{ route('app.finance.transaction.get_cost_detail') }}", {
                    _token: "{{ csrf_token() }}",
                    cost_id: $(this).val(),
                    user_id: $("#user").val()
                })
            })

            $('#form-group').on("change", ".selectCostDetail", function() {
                getCostAmount($(this), "{{ route('app.finance.transaction.get_cost_amount') }}", {
                    _token: "{{ csrf_token() }}",
                    cost_detail_id: $(this).val(),
                })
            })

            $('.paymentMethod').change(function() {
                getAccountNumber("{{ route('app.finance.transaction.get_account_number') }}", {
                    _token: "{{ csrf_token() }}",
                    payment_method_id: $(this).val(),
                })
            })
        })
    </script>
@endpush
