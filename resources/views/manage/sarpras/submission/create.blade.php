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
                        <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Tambah Pengajuan</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('app.submission.store') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0">Input Data</h6>
                        </div>
                        <div>
                            <span class="mr-2">Inputs : <span class="total-input">{{ session('total_input_data') ?? 0 }}</span></span>
                            <button type="button" class="btn btn-sm btn-danger minus"><i class="ri ri-minus">-</i></button>
                            <button type="button" class="btn btn-sm btn-success plus"><i class="ri ri-plus">+</i></button>
                        </div>
                    </div>
                    <hr>
                    <div id="input-parent">
                        @foreach (range(0, session('total_input_data') - 1) as $x)
                        <div class="row input">
                            <div class="col-sm-12">
                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="facility_id" class="form-label">Nama Sarana</label>
                                        <select type="text" name="facility_id[]" class="form-select @error('facility_id.' . $x) is-invalid @enderror" id="facility_id[]">
                                            <option value="" hidden>Pilih Sarana</option>
                                            @forelse ($facilities as $facility)
                                            <option value="{{ $facility->id }}" {{ select_old($facility->id, old('facility')) }}>{{ $facility->name }} ({{ $facility->brand }} | {{ $facility->description }})</option>
                                            @empty
                                            <option value="add-facility" {{ select_old('', old('facility')) }}>+ Tambah Sarana
                                            </option>
                                            @endforelse
                                        </select>
                                        @error('facility_id.' . $x)
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="date_required" class="form-label">Tanggal diPerlukan</label>
                                        <input type="date" name="date_required[]" class="form-control @error('date_required.' . $x) is-invalid @enderror" id="date_required[]" value="{{ old('date_required.' . $x) }}">
                                        @error('date_required.' . $x)
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="room_id" class="form-label">Pilih Ruangan</label>
                                        <select type="text" name="room_id[]" class="form-select @error('room_id.' . $x) is-invalid @enderror" id="room_id[]">
                                            <option value="" hidden>Pilih Ruangan</option>
                                            @forelse ($rooms as $room)
                                            <option value="{{ $room->id }}" {{ select_old($room->id, old('room')) }}>{{ $room->name }}</option>
                                            @empty
                                            <option value="add-room" {{ select_old('', old('room')) }}>+ Tambah Ruangan
                                            </option>
                                            @endforelse
                                        </select>
                                        @error('room_id.' . $x)
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="necessity" class="form-label">Keperluan</label>
                                        <input type="text" name="necessity[]" class="form-control @error('necessity.' . $x) is-invalid @enderror" id="necessity[]" value="{{ old('necessity.' . $x) }}">
                                        @error('necessity.' . $x)
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row align-items-center mb-3">
                                    <div class="col-sm-3">
                                        <label for="qty" class="form-label">Jumlah</label>
                                        <input type="number" name="qty[]" class="qty_{{ $x }} form-control @error('qty.' . $x) is-invalid @enderror" id="qty[]" value="{{ old('qty.' . $x) }}">
                                        @error('qty.' . $x)
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="price" class="form-label">Harga Satuan</label>
                                        <input type="number" name="price[]" class="price_{{ $x }} form-control @error('price.' . $x) is-invalid @enderror" id="price[]" value="{{ old('price.' . $x) }}">
                                        @error('price.' . $x)
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="postage_price" class="form-label">Harga Ongkir</label>
                                        <input type="number" name="postage_price[]" class="postage_price_{{ $x }} form-control @error('postage_price.' . $x) is-invalid @enderror" id="postage_price[]" value="{{ old('postage_price.' . $x) ?? 0 }}">
                                        @error('postage_price.' . $x)
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="total_price" class="form-label">Harga Total</label>
                                        <input type="number" name="total_price[]" class="total_price_{{ $x }} form-control @error('total_price.' . $x) is-invalid @enderror" id="total_price[]" value="{{ old('total_price.' . $x) ?? 0 }}" readonly>
                                        @error('total_price.' . $x)
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        @endforeach
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    $('.plus').click(function() {
        $.ajax({
            url: "{{ route('app.submission.plus_input') }}",
            type: 'POST',
            beforeSend: () => {
                $('.minus').attr('disabled', true);
                $('.plus').attr('disabled', true);
            },
            dataType: 'json',
            success: (result) => {
                if (result.status == 'success') {
                    $('.total-input').html(result.total);
                    $("#input-parent").append($("#input-parent .input:last").clone());

                    $('.minus').attr('disabled', false);
                    $('.plus').attr('disabled', false);
                }
            },
            error: () => {
                $('.minus').attr('disabled', false);
                $('.plus').attr('disabled', false);
                alert('Error. Please try again');
            }
        });
    });

    $('.minus').click(function() {
        $.ajax({
            url: "{{ route('app.submission.minus_input') }}",
            type: 'POST',
            beforeSend: () => {
                $('.minus').attr('disabled', true);
                $('.plus').attr('disabled', true);
            },
            dataType: 'json',
            success: (result) => {
                if (result.status == 'success') {
                    $('.total-input').html(result.total);
                    $("#input-parent .input:last").remove();

                    $('.minus').attr('disabled', false);
                    $('.plus').attr('disabled', false);
                } else {
                    $('.minus').attr('disabled', false);
                    $('.plus').attr('disabled', false);
                    alert('Tidak bisa kurang dari satu');
                }
            },
            error: () => {
                $('.minus').attr('disabled', false);
                $('.plus').attr('disabled', false);
                alert('Error. Please try again');
            }
        });
    });

    let loop = parseInt("{{ session('total_input_data') }}")
    for (let i = 0; i <= loop; i++) {
        $('.price_' + i + ',.qty_' + i + ',.postage_price_' + i).keyup(function() {
            let price = $(".price_" + i).val();
            let qty = $(".qty_" + i).val();
            let ongkir = $(".postage_price_" + i).val();
            let result = (price * qty) + parseInt(ongkir);
            $('.total_price_' + i).val(result);

        });
    }
</script>
@endpush