@extends('layouts.manage', ['title' => 'Permission'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Permission</h4>
                    <p class="mb-lg-0">Terdapat permission default yang tidak dapat diubah dan dihapus</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.permission.create') }}" class="btn btn-primary">Tambah</a>
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
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($permission->name) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if (!in_array($permission->id, [1, 2, 3, 4, 5]))
                                            <div class="edit">
                                                <a href="{{ route('app.permission.edit', $permission->id) }}"
                                                    class="btn btn-sm btn-success">Edit</a>
                                            </div>
                                            <div class="remove">
                                                <form action="{{ route('app.permission.destroy', $permission->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger c-delete">Hapus</button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="edit">
                                                <button class="btn btn-sm btn-success" disabled>Edit</button>
                                            </div>
                                            <div class="remove">
                                                <button class="btn btn-sm btn-danger" disabled>Hapus</button>
                                            </div>
                                        @endif
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
