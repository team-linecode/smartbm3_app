@extends('layouts.manage', ['title' => 'Absen Guru'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="">
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Absen Guru</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.teacher_absent.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Guru</th>
                            <th scope="col">Status</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teacher_absents as $teacher_absent)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $teacher_absent->user->name }}</td>
                                <td>{{ $teacher_absent->status() }}</td>
                                <td>{{ $teacher_absent->description ?? '-' }}</td>
                                <td>{{ $teacher_absent->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.teacher_absent.edit', $teacher_absent->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.teacher_absent.destroy', $teacher_absent->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-sm btn-danger c-delete">Hapus</button>
                                            </form>
                                        </div>
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
