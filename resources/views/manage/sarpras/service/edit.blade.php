@extends('layouts.manage', ['title' => 'Service'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.service.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Servis Fasilitas</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.service.update', $service->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="room_id" class="form-label">Ruangan</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select select2 @error('room_id') is-invalid @enderror" name="room_id"
                                id="room_id">
                                    <option value="" hidden>Pilih Ruangan</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ $room->id == $service->room_id ? 'selected' : '' }}>{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="facility_id" class="form-label">Fasilitas</label>
                            </div>
                            <div class="col-sm-9">
                                <select type="text" name="facility_id"
                                    class="form-select @error('facility_id') is-invalid @enderror" id="facility_id">
                                    <option value="" hidden>Pilih Fasilitas</option>
                                    @foreach($room_facilities as $facility)
                                        <option value="{{ $facility->facility_id }}" {{ $facility->facility_id == $service->facility_id ? 'selected' : '' }}>{{ $facility->facility->name }} | {{ $facility->facility->brand }}</option>
                                    @endforeach
                                </select>
                                @error('facility_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="date" class="form-label">Tanggal</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="date" id="date" value="{{ old('date') ?? $service->date }}">
                                @error('date')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="description" class="form-label">Keterangan</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="description" id="description" value="{{ $service->description }}">
                                @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-primary">Ubah</button>
                                    {{-- <div class="form-check ms-3">
                                        <input class="form-check-input" name="stay" type="checkbox" id="checkboxStay">
                                        <label class="form-check-label" for="checkboxStay">
                                            Tetap dihalaman ini
                                        </label>
                                    </div> --}}
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
    @include('component.datatables-script')
@endpush

@push('include-script')
    <script>
        $("#room_id").change(function() {
		let room = $(this).val()
		// let provider = $("#provider").val()
		let token = "{{ csrf_token() }}"
        console.log(room)
		$.ajax({
			url: '{{ route('app.service._get_facility') }}',
			data: 'room_id=' + room + '&_token=' + token,
			type: 'post',
			dataType: 'html',
			// beforeSent: $('.set-loader').css({
			// 	display: 'block'
			// }),
			success: function(result) {
				$("#facility_id").html(result)
				$("#facility_id").removeAttr('disabled')
			}
		});
	});
    </script>
@endpush
