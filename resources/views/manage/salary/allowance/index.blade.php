@extends('layouts.manage', ['title' => 'Data Tunjangan'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="">
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Data Tunjangan</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.allowance.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 dt-serverside">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tunjangan</th>
                            <th scope="col">Komponen</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allowances as $allowance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $allowance->name }}
                                    <div class="small text-primary">{{ $allowance->slug }}</div>
                                </td>
                                <td style="white-space: nowrap">
                                    <table class="table table-sm table-bordered mb-0 w-100">
                                        @forelse ($allowance->details as $detail)
                                            <tr>
                                                <td>{{ $detail->description }}</td>
                                                <td>{{ $detail->lastEducation->alias ?? '-' }}</td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-between">
                                                        <div>Rp.</div>
                                                        <div>{{ number_format($detail->salary) }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-danger">No Permissions <i
                                                        class="ri ri-close-line align-middle"></i></td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.allowance.edit', $allowance->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.allowance.destroy', $allowance->id) }}"
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
