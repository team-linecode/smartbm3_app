@extends('layouts.manage', ['title' => 'Input Absen'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="get">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3 mb-lg-0">
                            <label for="classroom" class="form-label">Kelas</label>
                            <select class="form-select @error('classroom') is-invalid @enderror" name="classroom"
                                id="classroom">
                                <option value="" hidden>Pilih Kelas</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}"
                                        {{ select_old($classroom->id, request()->get('classroom')) }}>
                                        {{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            @error('classroom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3 mb-lg-0">
                            <label for="expertise" class="form-label">Jurusan</label>
                            <select class="form-select @error('expertise') is-invalid @enderror" name="expertise"
                                id="expertise">
                                <option value="" hidden>Pilih Jurusan</option>
                                @foreach ($expertises as $expertise)
                                    <option value="{{ $expertise->id }}"
                                        {{ select_old($expertise->id, request()->get('expertise')) }}>
                                        {{ $expertise->name }}</option>
                                @endforeach
                            </select>
                            @error('expertise')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3 mb-lg-0">
                            <label class="d-none d-lg-block">&nbsp;</label>
                            <button class="btn btn-primary d-block w-100">Cari</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Data Siswa</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <div class="align-items-center d-flex gap-2">
                                        <div class="sakit">
                                            <form action="{{ route('app.picket_absent.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="hidden" name="status" value="s">
                                                <button type="button" data-id="s{{ $user->id }}"
                                                    class="btn {{ $user->absentToday('s')['button'] }} btn-absent" {{ $user->isApprenticeship() ? 'disabled' : '' }}>S</button>
                                            </form>
                                        </div>
                                        <div class="izin">
                                            <form action="{{ route('app.picket_absent.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="hidden" name="status" value="i">
                                                <button type="button" data-id="i{{ $user->id }}"
                                                    class="btn {{ $user->absentToday('i')['button'] }} btn-absent" {{ $user->isApprenticeship() ? 'disabled' : '' }}>I</button>
                                            </form>
                                        </div>
                                        <div class="alpha">
                                            <form action="{{ route('app.picket_absent.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="hidden" name="status" value="a">
                                                <button type="button" data-id="a{{ $user->id }}"
                                                    class="btn {{ $user->absentToday('a')['button'] }} btn-absent" {{ $user->isApprenticeship() ? 'disabled' : '' }}>A</button>
                                            </form>
                                        </div>
                                        <div class="apprenticeship">
                                            @if ($user->isApprenticeship())
                                                <button type="button" data-id="a{{ $user->id }}"
                                                    class="btn btn-primary" disabled>PKL</button>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="loader d-none" id="loader{{ $user->id }}">
                                                <svg viewBox="0 0 50 50">
                                                    <circle cx="25" cy="25" r="20"></circle>
                                                </svg>
                                            </div>
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
        $("body").on("click", ".btn-absent", function() {
            let form = $(this).closest('form')
            let user_id = $(this).prev().prev().val()

            $.ajax({
                url: form.attr("action"),
                type: "POST",
                data: form.serialize(),
                beforeSend: function() {
                    $('#loader' + user_id).removeClass('d-none');
                    $('.btn-absent').attr('disabled', 'disabled')
                },
                success: function(response) {
                    if (response.code === 200) {
                        if (response.type == 'create') {
                            if (response.status == 's') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .removeClass('btn-outline-primary')
                                    .addClass('btn-primary');
                            } else if (response.status == 'i') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .removeClass('btn-outline-warning')
                                    .addClass('btn-warning');
                            } else if (response.status == 'a') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .removeClass('btn-outline-danger')
                                    .addClass('btn-danger');
                            }
                        } else if (response.type == 'change') {
                            $('.btn-absent[data-id=s' + response.user_id + ']')
                                .addClass('btn-outline-primary')
                                .removeClass('btn-primary');
                            $('.btn-absent[data-id=i' + response.user_id + ']')
                                .addClass('btn-outline-warning')
                                .removeClass('btn-warning');
                            $('.btn-absent[data-id=a' + response.user_id + ']')
                                .addClass('btn-outline-danger')
                                .removeClass('btn-danger');

                            if (response.status == 's') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .removeClass('btn-outline-primary')
                                    .addClass('btn-primary');
                            } else if (response.status == 'i') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .removeClass('btn-outline-warning')
                                    .addClass('btn-warning');
                            } else if (response.status == 'a') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .removeClass('btn-outline-danger')
                                    .addClass('btn-danger');
                            }
                        } else if (response.type == 'delete') {
                            if (response.status == 's') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .addClass('btn-outline-primary')
                                    .removeClass('btn-primary');
                            } else if (response.status == 'i') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .addClass('btn-outline-warning')
                                    .removeClass('btn-warning');
                            } else if (response.status == 'a') {
                                $('.btn-absent[data-id=' + response.status + response.user_id + ']')
                                    .addClass('btn-outline-danger')
                                    .removeClass('btn-danger');
                            }
                        }
                    }

                    $('#loader' + user_id).addClass('d-none')
                    $('.btn-absent').removeAttr('disabled')
                    Toast.fire({
                        icon: 'success',
                        title: "Berhasil!"
                    })

                },
                error: function() {
                    $('#loader' + user_id).addClass('d-none');
                    $('.btn-absent').removeAttr('disabled')

                    Toast.fire({
                        icon: 'error',
                        title: "Server error! Try Again"
                    })
                }
            });
        });
    </script>
@endpush
