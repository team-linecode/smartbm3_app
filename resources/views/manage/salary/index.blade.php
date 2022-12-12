@extends('layouts.manage', ['title' => 'Penggajian'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="">
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Input Slip Gaji</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.salaries.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 dt-serverside">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Bulan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salaries as $salary)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('F Y', strtotime($salary->month)) }}</td>
                                <td class="fw-bold">{{ $salary->status == 'open' ? 'Dibuka' : 'Ditutup' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="detail">
                                            <a href="{{ route('app.salaries.show', $salary->id) }}"
                                                class="btn btn-sm btn-primary">Detail</a>
                                        </div>
                                        <div class="edit">
                                            <a href="{{ route('app.salaries.edit', $salary->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.salaries.destroy', $salary->id) }}"
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
