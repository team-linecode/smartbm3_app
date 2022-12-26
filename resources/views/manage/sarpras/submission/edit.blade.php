@extends('layouts.manage', ['title' => 'Pengajuan'])

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <a href="{{ route('app.submission.index') }}" class="btn btn-primary">
                            <i class="ri ri-arrow-left-line"></i>
                        </a>
                    </div>
                    <div>
                        <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Ubah Pengajuan</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('app.submission.update', $submission->submission_id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-3">
                            <label for="facility_id" class="form-label">Nama Sarana</label>
                            <select type="text" name="facility_id" class="form-select @error('facility_id') is-invalid @enderror" id="facility_id">
                                <option value="" hidden>Pilih Sarana</option>
                                @forelse ($facilities as $facility)
                                <option value="{{ $facility->id }}" {{ $submission->facility_id == $facility->id ? 'selected' : '' }} {{ select_old($facility->id, old('facility')) }} >{{ $facility->name }} ({{ $facility->brand }} | {{ $facility->description }})</option>
                                @empty
                                <option value="add-facility" {{ select_old('', old('facility')) }}>+ Tambah Sarana
                                </option>
                                @endforelse
                            </select>
                            @error('facility_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="date_required" class="form-label">Tanggal diPerlukan</label>
                            <input type="date" name="date_required" class="form-control @error('date_required') is-invalid @enderror" id="date_required" value="{{ $submission->date_required ? $submission->date_required : old('date_required') }}">
                            @error('date_required')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="room_id" class="form-label">Pilih Ruangan</label>
                            <select type="text" name="room_id" class="form-select @error('room_id') is-invalid @enderror" id="room_id">
                                <option value="" hidden>Pilih Ruangan</option>
                                @forelse ($rooms as $room)
                                <option value="{{ $room->id }}" {{ $submission->room_id == $room->id ? 'selected' : '' }} {{ select_old($room->id, old('room')) }}>{{ $room->name }}</option>
                                @empty
                                <option value="add-room" {{ select_old('', old('room')) }}>+ Tambah Ruangan
                                </option>
                                @endforelse
                            </select>
                            @error('room_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="necessity" class="form-label">Keperluan</label>
                            <input type="text" name="necessity" class="form-control @error('necessity') is-invalid @enderror" id="necessity" value="{{ $submission->necessity ? $submission->necessity : old('necessity') }}">
                            @error('necessity')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <div class="col-sm-3">
                            <label for="qty" class="form-label">Jumlah</label>
                            <input type="number" name="qty" class="qty form-control @error('qty') is-invalid @enderror" id="qty" value="{{ $submission->qty ? $submission->qty : old('qty') }}">
                            @error('qty')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="price" class="form-label">Harga Satuan</label>
                            <input type="number" name="price" class="price form-control @error('price') is-invalid @enderror" id="price" value="{{ $submission->price ? $submission->price : old('price') }}">
                            @error('price')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="postage_price" class="form-label">Harga Ongkir</label>
                            <input type="number" name="postage_price" class="postage_price form-control @error('postage_price') is-invalid @enderror" id="postage_price" value="{{ $submission->postage_price ? $submission->postage_price : 0 }}">
                            @error('postage_price')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="total_price" class="form-label">Harga Total</label>
                            <input type="number" name="total_price" class="total_price form-control @error('total_price') is-invalid @enderror" id="total_price" value="{{ $submission->total_price ? $submission->total_price : old('total_price') }}" readonly>
                            @error('total_price')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-9 offset-sm-3">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary">Simpan</button>
                                <div class="form-check ms-3">
                                    <input class="form-check-input" name="stay" type="checkbox" id="checkboxStay">
                                    <label class="form-check-label" for="checkboxStay">
                                        Tetap dihalaman ini
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('include-script')
<script>
    $('.price,.qty,.postage_price').keyup(function() {

        let price = $(".price").val();
        let qty = $(".qty").val();
        let ongkir = $(".postage_price").val();
        let result = (price * qty) + parseInt(ongkir);
        console.log(result)
        $('.total_price').val(result);

    });
</script>
@endpush