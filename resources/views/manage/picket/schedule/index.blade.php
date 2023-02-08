@extends('layouts.manage', ['title' => 'Jadwal Piket'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="">
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Jadwal Piket</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.picket_schedule.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 dt-serverside">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Hari</th>
                            <th scope="col">Anggota</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($picket_schedules as $picket_schedule)
                            <tr>
                                <td>{{ $picket_schedule->day->name }}</td>
                                <td style="white-space: nowrap">
                                    <table class="table table-sm table-bordered mb-0 table-light">
                                        @foreach ($picket_schedule->users as $user)
                                            <tr>
                                                <td width="40">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="me-3">{{ $user->name }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.picket_schedule.edit', $picket_schedule->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.picket_schedule.destroy', $picket_schedule->id) }}"
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
