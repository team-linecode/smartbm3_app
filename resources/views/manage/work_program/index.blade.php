@extends('layouts.manage', ['title' => 'Program Kerja'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Proker Saya</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.work_program.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Persentase</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($work_programs as $work_program)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $work_program->name }}</td>
                                <td>{{ $work_program->slug }}</td>
                                <td>{{ $work_program->percentage }}%</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.work_program.edit', $work_program->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.work_program.destroy', $work_program->id) }}"
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
