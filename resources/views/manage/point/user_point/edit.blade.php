@extends('layouts.manage', ['title' => 'Data Poin'])

@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.user_point.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Ubah Poin Siswa/i
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.user_point.update', $user_point->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="users" class="form-label mb-0">Nama</label>
                            </div>
                            <div class="col-sm-9">
                                {{ $user_point->user->name }} | {{ $user_point->user->myClass() }}
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="type" class="form-label">Tipe</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('type') is-invalid @enderror" name="type"
                                    id="type">
                                    <option value="" hidden>Pilih Tipe Point</option>
                                    <option value="plus" {{ select_old('plus', old('type'), true, $user_point->type) }}>
                                        (+) Penambahan Poin
                                    </option>
                                    <option value="minus" {{ select_old('minus', old('type'), true, $user_point->type) }}>
                                        (-) Pengurangan Poin
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3 d-none" id="selectPenalty">
                            <div class="col-sm-3">
                                <label for="penalty_point" class="form-label">Pelanggaran</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('penalty_point') is-invalid @enderror"
                                    name="penalty_point" id="penalty_point">
                                    <option value="" hidden>Pilih Pelanggaran</option>
                                    @foreach ($penalty_points as $penalty_point)
                                        <option value="{{ $penalty_point->id }}"
                                            {{ select_old($penalty_point->id, old('penalty_point'), true, $user_point->penalty->id ?? '') }}>
                                            {{ $penalty_point->name }}
                                            ({{ $penalty_point->point }} Poin)
                                        </option>
                                    @endforeach
                                </select>
                                @error('penalty_point')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3 d-none" id="inputDescription">
                            <div class="col-sm-3">
                                <label for="description" class="form-label">Alasan</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea type="number" name="description" class="form-control @error('description') is-invalid @enderror"
                                    id="description">{{ old('description') ?? $user_point->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3 d-none" id="inputPoint">
                            <div class="col-sm-3">
                                <label for="point" class="form-label">Poin</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" name="point"
                                    class="form-control @error('point') is-invalid @enderror" id="point"
                                    value="{{ old('point') ?? $user_point->point }}">
                                @error('point')
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

@push('include-script')
    <script>
        if ($('#type').val() == 'plus') {
            $('#selectPenalty').removeClass('d-none')
        } else if ($('#type').val() == 'minus') {
            $('#inputPoint').removeClass('d-none')
            $('#inputDescription').removeClass('d-none')
        }
    </script>

    @if (old('type'))
        @if (old('type') == 'plus')
            <script>
                $('#selectPenalty').removeClass('d-none')
            </script>
        @elseif (old('type') == 'minus')
            <script>
                $('#inputPoint').removeClass('d-none')
                $('#inputDescription').removeClass('d-none')
            </script>
        @endif
    @endif

    <script>
        $('#type').change(function() {
            let type = $(this).val()

            if (type == 'plus') {
                // add class
                $('#inputPoint').addClass('d-none')
                $('#inputDescription').addClass('d-none')
                // remove class
                $('#selectPenalty').removeClass('d-none')
            } else if (type == 'minus') {
                // add class
                $('#selectPenalty').addClass('d-none')
                // remove
                $('#inputPoint').removeClass('d-none')
                $('#inputDescription').removeClass('d-none')
            }
        })
    </script>
@endpush
