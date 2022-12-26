@extends('layouts.manage', ['title' => 'Submission'])

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
            <div>
                <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Pengajuan</h4>
            </div>
            <div class="text-center">
                <a href="{{ route('app.submission.create') }}" class="btn btn-primary">Tambah</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-bordered align-middle w-100 mb-0 dt-serverside">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Pemohon</th>
                        <th scope="col">Sarana yang diajukan</th>
                        <th scope="col">Catatan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tahap</th>
                        @if (auth()->user()->hasRole('FI') or auth()->user()->hasRole('principal') or auth()->user()->hasRole('HOF'))
                        <th scope="col">Opsi</th>
                        @endif
                        <th scope="col">Tanggal Pengajuan</th>
                        <th scope="col">Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submissions->sortBy('step') as $submission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucwords($submission->user->name) }}</td>
                        <td>
                            <table class="table table-bordered align-middle w-100 mb-0">
                                <tr>
                                    <th>Barang</th>
                                    <th>Ruangan</th>
                                    <th>Dibutuhkan</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Ongkir</th>
                                    <th class="text-nowrap">Total Harga</th>
                                    <th>Keperluan</th>
                                </tr>
                                @foreach($submission->submission_detail as $detail)
                                <tr>
                                    <td class="text-nowrap">{{ $detail->facility->name }} <small>({{ $detail->facility->brand }} | {{ $detail->facility->description }})</small></td>
                                    <td>{{ $detail->room->name }}</td>
                                    <td class="text-nowrap">{{ date('d F Y', strtotime($detail->date_required)) }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ $detail->price }}</td>
                                    <td>{{ $detail->postage_price }}</td>
                                    <td class="text-nowrap">Rp {{ number_format($detail->total_price) }}</td>
                                    <td>{{ $detail->necessity }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>{{ $submission->note }}</td>
                        <td>{{ ucwords($submission->status) }}</td>
                        <td class="text-nowrap">
                            @if($submission->step == 1)
                                Sarpras
                            @elseif($submission->step == 2)
                                Kepala Sekolah
                            @elseif($submission->step == 3)
                                Yayasan
                            @endif
                            </td>
                        @if (auth()->user()->hasRole('FI') or auth()->user()->hasRole('principal') or auth()->user()->hasRole('HOF'))
                        <td class="text-nowrap">
                            <div class="d-flex gap-2">
                                @if($submission->status == 'pending')
                                @if (auth()->user()->hasRole('HOF') && $submission->step == 3)
                                <a href="{{ route('app.submission.accept', $submission->id) }}" class="btn btn-sm btn-primary">Setujui</a>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#varyingcontentModal{{$submission->id}}" data-bs-whatever="@mdo">Tolak</button>
                                <!-- <a href="{{ route('app.submission.reject', $submission->id) }}" class="btn btn-sm btn-warning">Tolak</a> -->
                                @elseif(auth()->user()->hasRole('principal') && $submission->step == 2)
                                <a href="{{ route('app.submission.accept', $submission->id) }}" class="btn btn-sm btn-primary">Setujui</a>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#varyingcontentModal{{$submission->id}}" data-bs-whatever="@mdo">Tolak</button>
                                <!-- <a href="{{ route('app.submission.reject', $submission->id) }}" class="btn btn-sm btn-warning">Tolak</a> -->
                                @elseif(auth()->user()->hasRole('FI') && $submission->step == 1)
                                <a href="{{ route('app.submission.accept', $submission->id) }}" class="btn btn-sm btn-primary">Setujui</a>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#varyingcontentModal{{$submission->id}}" data-bs-whatever="@mdo">Tolak</button>
                                <!-- <a href="{{ route('app.submission.reject', $submission->id) }}" class="btn btn-sm btn-warning">Tolak</a> -->
                                @elseif (auth()->user()->hasRole('developer') or auth()->user()->id == $submission->user_id)
                                <div class="edit">
                                    <a href="{{ route('app.submission.edit', $submission->id) }}" class="btn btn-sm btn-success">Edit</a>
                                </div>
                                <div class="remove">
                                    <form action="{{ route('app.submission.destroy', $submission->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-sm btn-danger c-delete">Hapus</button>
                                    </form>
                                </div>
                                @else
                                No Action
                                @endif
                                @else
                                No Action
                                @endif
                            </div>
                        </td>
                        @endif
                        <td class="text-nowrap">{{ date('d F Y', strtotime($submission->created_at)) }}</td>
                        <td><a href="{{ route('app.submission.invoice', $submission->id) }}" class="btn btn-sm btn-info"><i class=""></i>O</a></td>
                    </tr>

                    <!-- Varying modal content -->
                    <div class="modal fade" id="varyingcontentModal{{$submission->id}}" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('app.submission.reject', $submission->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="varyingcontentModalLabel">Catatan Penolakan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="note" class="col-form-label">Catatan :</label>
                                            <textarea class="form-control" name="note" id="note"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Send message</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
            <!-- end table -->
        </div>
        <!-- end table responsive -->
    </div>
</div>


@stop