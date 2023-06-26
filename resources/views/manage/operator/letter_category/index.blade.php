@extends('layouts.manage', ['title' => 'Kategori Surat'])

@push('include-style')
@include('component.datatables-style')
@endpush

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                    <div>
                        <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Kategori Surat</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('app.letter_category.store') }}" method="post">
                    @csrf
                    <label for="">Name</label>
                    <input type="text" placeholder="Categories Name" class="form-control" name="name" id="name" require>
                    <button class="btn btn-sm btn-primary mt-1 float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table align-middle w-100 mb-0 datatables">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($letter_categories as $letter_category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $letter_category->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.letter_category.edit', $letter_category->id) }}" class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.letter_category.destroy', $letter_category->id) }}" method="post">
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
                                <td colspan="5" class="text-center">Tidak ada data!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
                <!-- end table responsive -->
            </div>
        </div>
    </div>
</div>
@stop

@push('include-script')
@include('component.datatables-script')
@endpush