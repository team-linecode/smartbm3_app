@extends('layouts.manage', ['title' => 'Biaya Sekolah'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')

    @include('component.form-error')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase mb-0">Data Biaya Sekolah</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tahun Ajaran</th>
                            <th scope="col">Data Biaya</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schoolyears as $schoolyear)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $schoolyear->name }}</td>
                                <td>
                                    @if ($schoolyear->costs()->exists())
                                        <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i>
                                            {{ $schoolyear->costs->count() }} Data</span>
                                    @else
                                        <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>
                                            {{ $schoolyear->costs->count() }} Data</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="duplicate">
                                            @if ($schoolyear->costs()->exists())
                                                <button class="btn btn-sm btn-success duplicate-modal"
                                                    data-schoolyear="{{ $schoolyear->slug }}">Duplikat</button>
                                            @endif
                                        </div>
                                        <div class="cost">
                                            <a href="{{ route('app.finance.cost.show', $schoolyear->slug) }}"
                                                class="btn btn-sm btn-primary">Lihat&nbsp;Biaya</a>
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

    <!-- Modal -->
    <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('app.finance.cost.duplicate') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="duplicateModalLabel">Duplikat Biaya</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="schoolyear" class="form-label">Tahun Ajaran</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('schoolyear') is-invalid @enderror" name="schoolyear"
                                    id="schoolyear">
                                </select>
                                @error('roles')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="destination" class="form-label">Tujuan</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-select @error('destination') is-invalid @enderror" name="destination[]"
                                    id="destination">
                                    <option value="" hidden>Pilih Role</option>
                                </select>
                                @error('destination')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-primary">Duplikat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('include-script')
    @include('component.jquery')
    @include('component.datatables-script')

    <script>
        const duplicateModal = new bootstrap.Modal('#duplicateModal', {
            keyboard: false
        })

        $('.duplicate-modal').click(function() {
            let schoolyear = $(this).data('schoolyear')

            $.ajax({
                url: "{{ route('app.finance.cost._get_roles') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    schoolyear: schoolyear
                },
                success: (response) => {
                    if (response.code == 200) {
                        $('#schoolyear').html(response.data.options1);
                        $('#destination').html(response.data.options2);

                        duplicateModal.show()
                    } else {
                        alert('Something went wrong...')
                    }
                }
            })
        })
    </script>
@endpush
