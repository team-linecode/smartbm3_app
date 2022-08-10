@extends('layouts.manage', ['title' => 'Role'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Role</h4>
                    <p class="mb-lg-0">Terdapat role default yang tidak dapat dihapus</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.role.create') }}" class="btn btn-primary">Tambah</a>
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
                            <th scope="col">Hak Akses</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($role->name) }}</td>
                                <td style="white-space: nowrap">
                                    <table class="table table-sm table-bordered mb-0 w-auto table-light">
                                        @forelse ($role->permissions as $permission)
                                            <tr>
                                                <td>{{ $permission->name }} <i class="ri ri-check-line align-middle"></i></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-danger">No Permissions <i class="ri ri-close-line align-middle"></i></td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.role.edit', $role->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        @if (!in_array($role->id, [1, 2, 3, 4, 5]))
                                            <div class="remove">
                                                <form action="{{ route('app.role.destroy', $role->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger c-delete">Hapus</button>
                                                </form>
                                            </div>
                                        @else
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
