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
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Input Poin Siswa/i
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('component.default-alert')

                    <form action="{{ route('app.user_point.store') }}" method="post">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="type" class="form-label">Tipe</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('type') is-invalid @enderror" name="type"
                                    id="type">
                                    <option value="" hidden>Pilih Tipe Point</option>
                                    <option value="plus" {{ select_old('plus', old('type')) }}>(+) Penambahan Poin
                                    </option>
                                    <option value="minus" {{ select_old('minus', old('type')) }}>(-) Pengurangan Poin
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
                                    @forelse ($penalty_categories as $penalty_category)
                                    <optgroup label="{{ $penalty_category->code }}. {{ $penalty_category->name }}">
                                            @foreach ($penalty_points as $penalty_point)
                                                @if ($penalty_category->id == $penalty_point->penalty_category_id)
                                                <option value="{{ $penalty_point->id }}">{{ $penalty_point->code }} {{ $penalty_point->name }}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @empty
                                        <option value="create_penalty_point">+ Tambah Poin Pelanggaran</option>
                                    @endforelse
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
                                    id="description">{{ old('description') }}</textarea>
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
                                    value="{{ old('point') }}">
                                @error('point')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="users" class="form-label">Siswa/i</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select select2 @error('users') is-invalid @enderror" name="users[]"
                                    id="users" multiple data-placeholder="Pilih Siswa/i">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ select_old_multiple($user->id, old('users')) }}>{{ $user->name }} -> {!! $user->myClass() !!}
                                        </option>
                                    @endforeach
                                </select>
                                @error('users')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="date" class="form-label">Tanggal & Waktu</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="datetime-local" name="date"
                                    class="form-control @error('date') is-invalid @enderror" id="date"
                                    value="{{ old('date') ?? date('Y-m-d\TH:i:s') }}">
                                @error('date')
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
        $('#penalty_point').change(function(){
            if ($(this).val() == 'create_penalty_point') {
                window.location.href = "{{ route('app.penalty_point.create') }}"
            }
        })
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
