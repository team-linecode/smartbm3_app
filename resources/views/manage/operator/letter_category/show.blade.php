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
        <form action="{{ route('app.room.store_facility', $room->id) }}" method="post">
            <div class="card-body">
                @csrf
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="mb-3 mb-md-0 mb-lg-0">
                            <label for="facility" class="form-label">Sarana</label>
                            <select class="form-select select2 @error('facility') is-invalid @enderror" name="facility"
                                id="facility">
                                <option value="" hidden>Pilih Sarana</option>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{ $facility->name }} | {{ $facility->brand }}</option>
                                @endforeach
                            </select>
                            @error('facility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3 mb-md-0 mb-lg-0">
                            <label for="procurement_year" class="form-label">Tahun Pengadaan</label>
                            <input type="number" class="form-control @error('procurement_year') is-invalid @enderror" name="procurement_year"
                                id="procurement_year" value="{{ old('procurement_year') ?? '' }}">
                            @error('procurement_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="divider">
                            <span class="fw-bold">Jumlah & Kondisi Barang</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0">
                            <label for="good" class="form-label">Baik</label>
                            <input type="number" class="form-control @error('good') is-invalid @enderror" name="good"
                                id="good" value="{{ old('good') ?? '0' }}">
                            @error('good')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0">
                            <label for="bad" class="form-label">Kurang Baik</label>
                            <input type="number" class="form-control @error('bad') is-invalid @enderror" name="bad"
                                id="bad" value="{{ old('bad') ?? '0' }}">
                            @error('bad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0">
                            <label for="broken_can_repaired" class="form-label">Rusak Dapat Diperbaiki</label>
                            <input type="number" class="form-control @error('broken_can_repaired') is-invalid @enderror"
                                name="broken_can_repaired" id="broken_can_repaired"
                                value="{{ old('broken_can_repaired') ?? '0' }}">
                            @error('broken_can_repaired')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0">
                            <label for="broken_cant_repaired" class="form-label">Rusak Tidak Dapat Diperbaiki</label>
                            <input type="number" class="form-control @error('broken_cant_repaired') is-invalid @enderror"
                                name="broken_cant_repaired" id="broken_cant_repaired"
                                value="{{ old('broken_cant_repaired') ?? '0' }}">
                            @error('broken_cant_repaired')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body text-end py-2">
                <button class="btn btn-primary">Simpan Sarana</button>
            </div>
        </form>
        <hr class="my-0">
        <div class="card-body">
            <h4 class="mb-0"><i class="ri-list-check-2 align-middle"></i> Data Sarana</h4>
        </div>
        <hr class="my-0">
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Merk</th>
                            <th>Tahun<br>Pengadaan</th>
                            <th>Kondisi</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($room_facilities as $rf)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rf->facility->name }}</td>
                                <td>{{ $rf->facility->brand }}</td>
                                <td>{{ $rf->procurement_year }}</td>
                                <td>
                                    <table>
                                        <tr>
                                            <th>Baik</th>
                                            <td class="px-2">:</td>
                                            <td>{{ $rf->good }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kurang Baik</th>
                                            <td class="px-2">:</td>
                                            <td>{{ $rf->bad }}</td>
                                        </tr>
                                        <tr>
                                            <th>Rusak dapat diperbaiki</th>
                                            <td class="px-2">:</td>
                                            <td>{{ $rf->broken_can_repaired }}</td>
                                        </tr>
                                        <tr>
                                            <th>Rusak tidak dapat diperbaiki</th>
                                            <td class="px-2">:</td>
                                            <td>{{ $rf->broken_cant_repaired }}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.room.edit_facility', [$room->id, $rf->id]) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.room.delete_facility', [$room->id, $rf->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger c-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('include-script')
    @include('component.datatables-script')
@endpush
