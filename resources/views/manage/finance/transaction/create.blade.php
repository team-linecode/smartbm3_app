@extends('layouts.manage', ['title' => 'Transaksi'])

@push('include-style')
<!-- choices -->
<link rel="stylesheet" href="/vendor/manage/assets/libs/choices.js/public/assets/styles/choices.min.css">
<!-- flatpickr -->
<link rel="stylesheet" href="/vendor/manage/assets/libs/flatpickr/flatpickr.min.css">
@endpush

@section('content')
<form action="{{ route('app.finance.transaction.save_transaction') }}" method="post">
    @csrf
    <div class="card">
        <div class="card-body border-bottom border-bottom-dashed p-4">
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
                    <select name="user_id" class="form-select w-100" id="choices-single-default" data-choices>
                        <option value="">- Pilih Siswa/i -</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ select_old($user->id, old('user_id')) }}>{{ $user->name }} [{{ $user->myClass() }}]{{ $user->alumni == '1' ? '[Alumni]' : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3 justify-content-end">
                <div class="col-lg-3 col-sm-6">
                    <label for="invoice_id">Invoice ID</label>
                    <input type="text" class="form-control bg-light border-0" name="invoice_id" id="invoice_id" value="#BMM{{ rand(100000, 999999) }}" readonly="readonly" />
                </div>
                <div class="col-lg-3 col-sm-6">
                    <label for="date-field">Tanggal Transaksi</label>
                    <input type="text" class="form-control bg-light border-0 @error('date') is-invalid @enderror" name="date" id="date-field" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time placeholder="Pilih Tanggal">
                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-lg-6 col-sm-6 text-end align-self-end">
                    <button class="btn btn-primary disabled" id="btnNext">Berikutnya <i class="ri-arrow-right-line align-middle"></i></button>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</form>
@stop

@push('include-script')

@include('component.loading')

<!-- choices -->
<script src="/vendor/manage/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<!-- flatpickr -->
<script src="/vendor/manage/assets/libs/flatpickr/flatpickr.min.js"></script>

@if($errors->has('date'))
<script>
    getDetailUser("{{ route('app.finance.transaction.get_user') }}", {
        _token: "{{ csrf_token() }}",
        user_id: $('#choices-single-default').val()
    })
</script>
@endif

<script>
    $('#choices-single-default').change(function() {
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
</script>
@endpush