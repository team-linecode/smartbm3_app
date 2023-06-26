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
                    <form action="{{ route('app.service.store') }}" method="post">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="room_id" class="form-label">Ruangan</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select select2 @error('room_id') is-invalid @enderror" name="room_id"
                                id="room_id">
                                    <option value="" hidden>Pilih Ruangan</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
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
                                    class="form-select @error('facility_id') is-invalid @enderror" id="facility_id" disabled>
                                    <option value="" hidden>Pilih Fasilitas</option>
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
                                <input type="date" class="form-control" name="date" id="date" value="{{ old('date') ?? date('Y-m-d') }}">
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
                                <input type="text" class="form-control" name="description" id="description">
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
                                    <button class="btn btn-primary">Simpan</button>
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
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Servis</h4>
                    <p class="mb-lg-0">Detail Data Servis</p>
                </div>
                {{-- <div class="text-center">
                    <a href="{{ route('app.service.create') }}" class="btn btn-primary">Tambah</a>
                </div> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Ruangan</th>
                            <th scope="col">Tanggal Service</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $service->facility->name }} | {{ $service->facility->brand }}</td>
                                <td>{{ $service->room->name }}</td>
                                <td>{{ date('d F Y', strtotime($service->date)) }}</td>
                                <td>{{ $service->description }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.service.edit', $service->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.service.destroy', $service->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-sm btn-danger c-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
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
