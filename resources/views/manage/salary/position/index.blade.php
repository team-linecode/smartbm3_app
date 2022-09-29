@extends('layouts.manage', ['title' => 'Data Jabatan'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="">
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Data Jabatan</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.position.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 dt-serverside">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Gaji/Bln</th>
                            <th scope="col">Anggota</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($positions as $position)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $position->name }}
                                    <div class="small text-primary"><b>slug:</b> {{ $position->slug }}</div>
                                </td>
                                <td>Rp. {{ number_format($position->salary) }}</td>
                                <td style="white-space: nowrap">
                                    <table class="table table-sm table-bordered mb-0 table-light">
                                        @forelse ($position->users as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="me-3">{{ $user->name }}</div>
                                                        <div class="remove">
                                                            <form
                                                                action="{{ route('app.position.destroy_user', [$position->slug, $user->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm rounded-0 c-delete"><i
                                                                        class="ri ri-close-line align-middle"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-danger">Tidak terdaftar <i
                                                        class="ri ri-close-line align-middle"></i></td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.position.edit', $position->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.position.destroy', $position->id) }}"
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
                                <td colspan="4" class="text-center text-danger">Tidak ada data!</td>
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
