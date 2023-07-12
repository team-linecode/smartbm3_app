@extends('layouts.manage', ['title' => 'Pembayaran'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase mb-2 mb-md-0 mb-lg-0">Pilih Siswa/i</h4>
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
                ajax: "{{ route('datatable.choose_student_json') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'classroom.alias',
                        name: 'classroom.alias',
                    },
                    {
                        data: 'expertise.name',
                        name: 'expertise.name',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [2, 'asc'],
                    [3, 'asc'],
                    [1, 'asc'],
                ],
            });
        });
    </script>
@endpush
