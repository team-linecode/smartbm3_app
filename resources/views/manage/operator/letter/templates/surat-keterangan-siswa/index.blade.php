@extends('layouts.manage', ['title' => 'Letter'])

@push('include-style')
@include('component.datatables-style')
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="ri-exchange-box-line align-middle"></i> Input Data Surat</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('app.letter.show', $slug) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="letter_number" class="form-label">Nomor Surat</label>
                        <input type="text" name="letter_number" class="form-control @error('letter_number') is-invalid @enderror" id="letter_number" value="{{ old('letter_number') }}">
                        @error('letter_number')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Siswa</label>
                        <select type="text" name="user_id[]" class="form-select select2 @error('user_id') is-invalid @enderror" id="user_id" multiple>
                            <option value="" hidden>Pilih Siswa</option>
                            @forelse ($users as $user)
                            <option value="{{ $user->id }}" {{ select_old($user->id, old('user')) }}>{{ $user->name }} ({{ $user->myClass() }})</option>
                            @empty
                            <option value="add-user" {{ select_old('', old('user')) }}>+ Tambah Siswa
                            </option>
                            @endforelse
                        </select>
                        @error('user_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary mt-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('include-script')
@include('component.datatables-script')
@endpush

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