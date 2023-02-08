@extends('layouts.manage', ['title' => 'Data Siswa'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')

    @include('component.form-error')

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{ route('app.student.index') }}" class="btn btn-light me-2"><i class="ri-arrow-left-s-line"></i></a>
                <h4 class="card-title text-uppercase mb-0">Tahun Ajaran</h4>
            </div>
        </div>
    </div>

    <div class="list-group shadow mb-4">
        @foreach ($schoolyears as $schoolyear)
            <a href="" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="ri-file-list-3-line align-middle me-2"></i>{{ $schoolyear->name }}
                    </div>
                    @if ($schoolyear->graduated == 0)
                        <div class="text-danger">BELUM LULUS</div>
                    @else
                        <div class="text-success">LULUS</div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
@stop

@push('include-script')
    @include('component.jquery')
    @include('component.datatables-script')
    @include('component.display-password')

    <script>
        $(function() {
            let table = $('.dt-serverside').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('datatable.student_json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'classroom.name',
                        name: 'classroom.name',
                    },
                    {
                        data: 'expertise.name',
                        name: 'expertise.name',
                    },
                    {
                        data: 'username',
                        name: 'username',
                    },
                    {
                        data: 'password',
                        name: 'password',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "order": [
                    [2, "ASC"],
                    [3, "ASC"],
                    [1, "ASC"],
                ],
            });
        });
    </script>
@endpush
