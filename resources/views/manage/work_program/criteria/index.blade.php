@extends('layouts.manage', ['title' => 'Program Kerja'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Kriteria Nilai</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.value_criteria.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Kriteria</th>
                            <th scope="col">Status</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($value_criterias as $criteria)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $criteria->category->name }}</td>
                                <td>{{ $criteria->name }}</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input form-check-status" type="checkbox"
                                            value="{{ $criteria->status }}" id="criteria{{ $criteria->id }}"
                                            {{ $criteria->status == 'active' ? 'checked' : '' }}
                                            data-criteria-id="{{ $criteria->id }}">
                                        <label class="form-check-label" for="criteria{{ $criteria->id }}">
                                            @if ($criteria->status == 'active')
                                                <span class="text-status text-primary">Digunakan</span>
                                            @else
                                                <span class="text-status text-danger">Tidak Digunakan</span>
                                            @endif
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.value_criteria.edit', $criteria->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.value_criteria.destroy', $criteria->id) }}"
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

    <script>
        $('.form-check-status').change(function() {
            let val = $(this).val();

            if (val == 'active') {
                $(this).val('nonactive');
                $(this).next().find('.text-status').removeClass('text-primary').addClass('text-danger').html(
                    'Tidak Digunakan')
            } else if (val == 'nonactive') {
                $(this).val('active');
                $(this).next().find('.text-status').removeClass('text-danger').addClass('text-primary').html(
                    'Digunakan')
            }

            $.ajax({
                url: "{{ route('app.app.value_criteria.update_status') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: $(this).val(),
                    criteria_id: $(this).data('criteria-id')
                },
                beforeSend: () => {
                    $('.form-check-status').attr('disabled', 'disabled')
                },
                success: (res) => {
                    $('.form-check-status').removeAttr('disabled')

                    if (res.status == '200') {
                        Toast.fire({
                            icon: 'success',
                            title: "Status Diubah"
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: "Terjadi Kesalahan!"
                        })
                    }
                }
            });
        })
    </script>
@endpush
