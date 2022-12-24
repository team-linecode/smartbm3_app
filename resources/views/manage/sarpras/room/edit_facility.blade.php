@extends('layouts.manage', ['title' => 'Ruangan'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center align-items-center">
                <div class="col-6 col-lg-2">
                    <img src="{{ Storage::url('icon/building.png') }}" class="img-fluid mb-4 mb-md-0 mb-lg-0" alt="building">
                </div>
                <div class="col-lg-10">
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th colspan="3">
                                <h5 class="text-primary fw-bold mb-0"><i class="ri-information-line align-middle"></i>
                                    Detail Ruangan</h5>
                            </th>
                        </tr>
                        <tr>
                            <th>Nama Ruangan</th>
                            <td><i class="ri-arrow-right-s-fill align-middle"></i> {{ $room->name }}</td>
                        </tr>
                        <tr>
                            <th>Gedung</th>
                            <td><i class="ri-arrow-right-s-fill align-middle"></i> {{ $room->building->name }}</td>
                        </tr>
                        <tr>
                            <th>Lantai</th>
                            <td><i class="ri-arrow-right-s-fill align-middle"></i> Lantai {{ $room->stage }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <hr class="my-0">
        <div class="card-body">
            <h4 class="mb-0"><i class="ri-edit-line align-middle"></i> Input Sarana</h4>
        </div>
        <hr class="my-0">
        <div class="card-body">
            <form action="{{ route('app.room.update_facility', [$room->id, $facility->id]) }}" method="post">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0">
                            <label for="facility" class="form-label">Sarana</label>
                            <select class="form-select select2 @error('facility') is-invalid @enderror" name="facility"
                                id="facility">
                                <option value="" hidden>Pilih Sarana</option>
                                @foreach ($facilities as $f)
                                    <option value="{{ $f->id }}" {{ select_old($f->id, old('facility'), true, $facility->id) }}>{{ $f->name }}</option>
                                @endforeach
                            </select>
                            @error('facility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0">
                            <label for="amount" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount"
                                id="amount" value="{{ old('amount') ?? $room->facilities()->where('facility_id', $facility->id)->first()->pivot->amount }}">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label class="d-none d-md-block d-lg-block d-xl-block">&nbsp;</label>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('include-script')
    @include('component.datatables-script')
@endpush
