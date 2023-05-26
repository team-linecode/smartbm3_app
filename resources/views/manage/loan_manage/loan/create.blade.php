@extends('layouts.manage', ['title' => 'Peminjaman'])

@push('include-style')
    <style>
        video {
            transform: rotateY(180deg);
            -webkit-transform: rotateY(180deg);
            /* Safari and Chrome */
            -moz-transform: rotateY(180deg);
            /* Firefox */
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center" id="scanqr">
        <div class="col-lg-6">
            <div class="card" style="overflow: hidden;">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.loan.index') }}" class="btn btn-light">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Scan Kartu Peminjaman
                            </h4>
                        </div>
                    </div>
                </div>
                <div style="width: 100%" id="reader"></div>
                <div class="card-body text-center">
                    <button class="btn btn-primary" id="manualy_create">Input Manual</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createLoanModal" tabindex="-1" aria-labelledby="createLoanModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createLoanModalLabel">Masukkan Informasi Peminjaman</h1>
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
                            <div class="col-6">
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

                        <div class="mb-3">
                            <label for="user" class="form-label">Penanggung Jawab</label>
                            <select class="select2 @error('user') is-invalid @enderror" name="user" id="user">
                            </select>
                            @error('user')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="teacher" class="form-label">Pengajar</label>
                            <select class="form-select select2-custom @error('teacher') is-invalid @enderror" name="teacher"
                                id="teacher">
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
                            <select class="form-select select2-custom @error('room') is-invalid @enderror" name="room"
                                id="room">
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
                            <select class="form-select select2-custom @error('facilities') is-invalid @enderror"
                                name="facilities[]" id="facilities" multiple>
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
                                id="description" value="{{ old('description') }}" placeholder="ex: nama barang, jumlah pinjam"></textarea>
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
                                value="{{ old('loan_date') ?? date('Y-m-d\TH:i') }}">
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
                                value="{{ old('estimation_return_date') ?? date('Y-m-d\TH:i') }}">
                            @error('estimation_return_date')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="approvers" class="form-label">Perlu Persetujuan dari</label>
                            <select class="form-select select2-custom @error('approvers') is-invalid @enderror"
                                name="approvers[]" id="approvers" multiple>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"
        integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // select2
        $(".select2-custom").select2({
            theme: "bootstrap-5",
            dropdownParent: $(".modal")
        });

        const createLoanModal = new bootstrap.Modal('#createLoanModal', {
            keyboard: false
        })

        $('#expertise').change(function() {
            let classroom_id = $('#classroom').val()
            let expertise_id = $('#expertise').val()

            if (classroom_id == "") {
                $(this).val("")
                alert("Harap pilih kelas!")
            }

            findUsersByClass(classroom_id, expertise_id);
        })

        // This method will trigger user permissions
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                var cameraId = devices[0].id;

                const html5QrCode = new Html5Qrcode("reader");

                $('#manualy_create').click(function() {
                    createLoanModal.show();
                    html5QrCode.pause();
                })

                html5QrCode.start(
                    cameraId, {
                        fps: 50,
                        qrbox: {
                            width: 200,
                            height: 200,
                        },
                    },
                    (decodedText, decodedResult) => {
                        html5QrCode.pause()
                        var audio = new Audio('/storage/sound/scan-success.mp3');
                        audio.play();

                        $.ajax({
                            url: "{{ route('app.loan.find_members_by_scan') }}",
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}",
                                uid: decodedText
                            },
                            dataType: 'json',
                            success: (result) => {
                                let member = result.data.member

                                $('#classroom').val(member.classroom_id).attr('disabled',
                                    'disabled')
                                $('#expertise').val(member.expertise_id).attr('disabled',
                                    'disabled')

                                findUsersByClass(member.classroom_id, member.expertise_id)

                                createLoanModal.show();
                            },
                            error: () => {
                                html5QrCode.resume()
                            }
                        })
                    },
                    (errorMessage) => {
                        // error
                    }).catch((err) => {
                    // error
                });
                $('.close-modal').click(() => {
                    html5QrCode.resume()
                })
            }
        }).catch(err => {
            // handle err
        });

        $('#room').change(function() {
            let room_id = $(this).val()

            $.ajax({
                url: "{{ route('app.loan.find_facilities_by_room') }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    room_id: room_id
                },
                dataType: 'json',
                success: (result) => {
                    console.log(result)
                    $('#facilities').html(result.options)
                },
                error: () => {
                    alert('Try Again!');
                }
            })
        })

        function findUsersByClass(classroom_id, expertise_id) {
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
                    console.log(result)
                    $('#user').html(result.options)
                },
                error: () => {
                    html5QrCode.resume()
                }
            })
        }
    </script>
@endpush
