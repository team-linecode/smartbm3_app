@extends('layouts.manage', ['title' => 'Data Siswa'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')

    @include('component.form-error')

    <a href="{{ route('app.student.alumni.index') }}" class="btn btn-primary mb-3">Input Kelulusan</a>

    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div class="">
                    <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Data Siswa</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.student.create') }}" class="btn btn-primary">Tambah</a>
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
                            <th scope="col">Jurusan</th>
                            <th scope="col">Username</th>
                            <th scope="col">Kata Sandi</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
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
