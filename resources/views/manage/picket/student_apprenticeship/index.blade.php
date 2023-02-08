@extends('layouts.manage', ['title' => 'Siswa PKL'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="">
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Siswa PKL</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.student_apprenticeship.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student_apprenticeships as $student_apprenticeship)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student_apprenticeship->user->name }}</td>
                                <td>{{ $student_apprenticeship->user->myClass() }}</td>
                                <td>{{ $student_apprenticeship->start_date != NULL ? date('d M Y', strtotime($student_apprenticeship->start_date)) : '-' }}</td>
                                <td>{{ $student_apprenticeship->end_date != NULL ? date('d M Y', strtotime($student_apprenticeship->end_date)) : '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.student_apprenticeship.edit', $student_apprenticeship->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.student_apprenticeship.destroy', $student_apprenticeship->id) }}"
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
