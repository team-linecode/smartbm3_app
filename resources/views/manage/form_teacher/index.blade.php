@extends('layouts.manage', ['title' => 'Wali Kelas'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Wali Kelas</h4>
                    <p class="mb-lg-0">Setiap guru dapat memegang lebih dari satu kelas</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.form_teacher.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 dt-serverside">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($form_teachers as $form_teacher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($form_teacher->user->name) }}</td>
                                <td>{{ $form_teacher->classroom->name . ' ' . $form_teacher->expertise->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.form_teacher.edit', $form_teacher->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.form_teacher.destroy', $form_teacher->id) }}"
                                                method="post">
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
                            <td colspan="4" class="text-center">Tidak ada data!</td>
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
