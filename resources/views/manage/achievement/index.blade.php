@extends('layouts.manage', ['title' => 'Prestasi'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Prestasi</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.achievement.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Wali Kelas</th>
                            <th scope="col">Siswa/i</th>
                            <th scope="col">Kegiatan</th>
                            <th scope="col">Juara</th>
                            <th scope="col">Tingkat</th>
                            <th scope="col">Lampiran</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($achievements as $achievement)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $achievement->teacher->name }}</td>
                                <td>{{ $achievement->student->name }}&nbsp;-&nbsp;{{ $achievement->student->myClass() }}
                                </td>
                                <td>{{ $achievement->name }}</td>
                                <td>{{ $achievement->champion }}</td>
                                <td>{{ $achievement->level }}</td>
                                <td>
                                    @forelse ($achievement->attachments as $i => $attachment)
                                        <a href="{{ Storage::url($attachment->file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary px-2">{{ $i + 1 }}</a>
                                    @empty
                                        -
                                    @endforelse
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!--@if($achievement->teacher->id == auth()->user()->id)-->
                                        <!--<div class="edit">-->
                                        <!--    <a href="{{ route('app.achievement.edit', $achievement->id) }}"-->
                                        <!--        class="btn btn-sm btn-success">Edit</a>-->
                                        <!--</div>-->
                                        <!--<div class="remove">-->
                                        <!--    <form action="{{ route('app.achievement.destroy', $achievement->id) }}"-->
                                        <!--        method="post">-->
                                        <!--        @csrf-->
                                        <!--        @method('delete')-->
                                        <!--        <button type="button" class="btn btn-sm btn-danger c-delete">Hapus</button>-->
                                        <!--    </form>-->
                                        <!--</div>-->
                                        <!--@else-->
                                        <!--<button type="button" class="btn btn-sm btn-light" disabled><i class="ri-forbid-line"></i></button>-->
                                        <!--@endif-->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
