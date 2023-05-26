@extends('layouts.manage', ['title' => 'Data Peminjaman Lab'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Peminjaman Lab</h4>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.loan.create') }}" class="btn btn-primary"><i
                            class="ri-qr-code-line align-middle"></i> Scan</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Penanggung&nbsp;Jawab</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Pengajar</th>
                            <th scope="col">Waktu&nbsp;Mulai</th>
                            <th scope="col">Estimasi&nbsp;Selesai</th>
                            <th scope="col">Status</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loan->user->name ?? '-' }}</td>
                                <td class="fw-bold text-primary">{{ $loan->user->MyClass() ?? '-' }}</td>
                                <td>{{ $loan->teacher->name ?? '-' }}</td>
                                <td>{{ $loan->loan_date ?? '' }}</td>
                                <td>{{ $loan->estimation_return_date ?? '' }}</td>
                                <td>{{ $loan->status() }}
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="show">
                                            <button class="btn btn-sm btn-success btn_detail_loan"
                                                data-uid="{{ $loan->uid }}">Detail</button>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.loan.destroy', $loan->id) }}" method="post">
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

    <div class="modal fade" id="detailLoanModal" tabindex="-1" aria-labelledby="detailLoanModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailLoanModalLabel">Masukkan Informasi Peminjaman</h1>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('app.loan.store') }}" method="post" id="formCreateLoan">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="classroom" class="form-label">Kelas</label>
                                <select class="form-select @error('classroom') is-invalid @enderror" name="classroom"
                                    id="classroom" disabled>
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
                            <div class="col-6">
                                <label for="expertise" class="form-label">Jurusan</label>
                                <select class="form-select @error('expertise') is-invalid @enderror" name="expertise"
                                    id="expertise" disabled>
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

                        <div class="mb-3">
                            <label for="user" class="form-label">Penanggung Jawab</label>
                            <select class="form-select @error('user') is-invalid @enderror" name="user" id="user"
                                disabled>
                            </select>
                            @error('user')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="teacher" class="form-label">Pengajar</label>
                            <select class="form-select @error('teacher') is-invalid @enderror" name="teacher" id="teacher"
                                disabled>
                                <option value="" hidden>Pilih Pengajar</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('teacher')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="room" class="form-label">Ruangan</label>
                            <select class="form-select @error('room') is-invalid @enderror" name="room" id="room"
                                disabled>
                                <option value="" hidden>Pilih Ruangan</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                            @error('room')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="facilities" class="form-label">Barang</label>
                            <select class="form-select select2 @error('facilities') is-invalid @enderror"
                                name="facilities[]" id="facilities" multiple disabled>
                            </select>
                            @error('facilities')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" name="description" class="form-control @error('description') is-invalid @enderror"
                                id="description" placeholder="ex: nama barang, jumlah pinjam" disabled>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="loan_date" class="form-label">Waktu Pinjam</label>
                            <input type="datetime-local" name="loan_date"
                                class="form-control @error('loan_date') is-invalid @enderror" id="loan_date"
                                value="{{ old('loan_date') ?? date('Y-m-d\TH:i') }}" disabled>
                            @error('loan_date')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estimation_return_date" class="form-label">Estimasi Waktu Kembali</label>
                            <input type="datetime-local" name="estimation_return_date"
                                class="form-control @error('estimation_return_date') is-invalid @enderror"
                                id="estimation_return_date"
                                value="{{ old('estimation_return_date') ?? date('Y-m-d\TH:i') }}" disabled>
                            @error('estimation_return_date')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="approvers" class="form-label">Perlu Persetujuan dari</label>
                            <select class="form-select select2 @error('approvers') is-invalid @enderror"
                                name="approvers[]" id="approvers" multiple disabled>
                                @foreach ($approvers as $approver)
                                    <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                @endforeach
                            </select>
                            @error('approvers')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger close-modal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="formCreateLoan" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@stop

@push('include-script')
    @include('component.datatables-script')

    <script>
        // select2
        $(".select2-custom").select2({
            theme: "bootstrap-5",
            dropdownParent: $(".modal")
        });

        const detailLoanModal = new bootstrap.Modal('#detailLoanModal', {
            keyboard: false
        })

        $("body").on("click", ".btn_detail_loan", function() {
            uid = $(this).data('uid')

            $.ajax({
                url: "{{ route('app.loan.get_detail') }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    uid: uid,
                },
                dataType: 'json',
                success: (result) => {
                    if (result.code == 200) {
                        const pluck = (arr, key) => arr.map(i => i[key])

                        findUsersByClass(result.data.member.classroom_id, result.data.member
                            .expertise_id, result.data.user_id)
                        findFacilitiesByRoom(result.data.room_id, pluck(result.data.facilities, 'id'))

                        $('#classroom').val(result.data.member.classroom_id)
                        $('#expertise').val(result.data.member.expertise_id)
                        $('#teacher').val(result.data.teacher_id)
                        $('#room').val(result.data.room_id)
                        $('#approvers').val(pluck(result.data.approvers, 'position_id'))

                        detailLoanModal.show()
                    } else {
                        alert('404 Not Found!');
                    }
                },
                error: () => {
                    alert('Something went wrong!')
                }
            })
        });

        function findFacilitiesByRoom(room_id, selected_id = null) {
            $.ajax({
                url: "{{ route('app.loan.find_facilities_by_room') }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    room_id: room_id
                },
                dataType: 'json',
                success: (result) => {
                    $('#facilities').html(result.options)
                    $('#facilities').val(selected_id)
                },
                error: () => {
                    alert('Something went wrong!');
                }
            })
        }


        function findUsersByClass(classroom_id, expertise_id, selected_id = null) {
            $.ajax({
                url: "{{ route('app.loan.find_users_by_class') }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    classroom_id: classroom_id,
                    expertise_id: expertise_id,
                },
                dataType: 'json',
                success: (result) => {
                    $('#user').html(result.options)
                    if (selected_id != null) {
                        $('#user').val(selected_id)
                    }
                },
                error: () => {
                    alert('Something went wrong!')
                }
            })

            return true
        }

        $('.single-image-popup').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            }
        });
    </script>
@endpush
