@extends('layouts.manage', ['title' => 'Data Guru'])

@push('include-style')
@include('component.datatables-style')
@endpush

@section('content')

@include('component.form-error')

<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
            <div class="">
                <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Data Guru</h4>
            </div>
            <div class="text-center">
                <a href="{{ route('app.teacher.create') }}" class="btn btn-primary">Tambah</a>
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
                        <th scope="col">Pendidikan</th>
                        <th scope="col">Username</th>
                        <th scope="col">Kata Sandi</th>
                        <th scope="col">Tanggal Tugas</th>
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
            ajax: "{{ route('datatable.teacher_json') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'last_education_id',
                    name: 'last_education_id',
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
                    data: 'entry_date',
                    name: 'entry_date',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "order": [[1, "ASC"]],
        });
    });
</script>
@endpush
