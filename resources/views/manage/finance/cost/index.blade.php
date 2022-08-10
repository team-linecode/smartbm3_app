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
                    @foreach($schoolyears as $schoolyear)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $schoolyear->name }}</td>
                        <td>
                            @if($schoolyear->costs()->exists())
                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> {{ $schoolyear->costs->count() }} Data</span>
                            @else
                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> {{ $schoolyear->costs->count() }} Data</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <div class="cost">
                                    <a href="{{ route('app.finance.cost.show', $schoolyear->slug) }}" class="btn btn-sm btn-primary">Lihat&nbsp;Biaya</a>
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
@include('component.jquery')
@include('component.datatables-script')
@endpush