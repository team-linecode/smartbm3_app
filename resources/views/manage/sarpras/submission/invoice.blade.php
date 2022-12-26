@extends('layouts.manage', ['title' => 'Invoice Submission'])

@push('include-style')
<style>
    @media print {
        header {
            display: none !important;
        }

        .navbar-menu {
            display: none !important;
        }

        .page-title-box {
            display: none !important;
        }

        .non-print {
            display: none !important;
        }

        body {
            -webkit-print-color-adjust: exact !important;
            /* Chrome, Safari 6 – 15.3, Edge */
            color-adjust: exact !important;
            /* Firefox 48 – 96 */
        }
    }

    @page {
        size: A4 landscape;
        -webkit-print-color-adjust: exact !important;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead>
                <tr class="text-center">
                    <th colspan="9">
                        <h4 class="font-weight-bold mb-0">SMK BINA MANDIRI MULTIMEDIA <br> FORMULIR PERMOHONAN PEMBELIAN BARANG</h4>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">No. Invoice : {{$submission->invoice}}</th>
                    <th colspan="4" class="text-nowrap">Tanggal Pengajuan : {{date('d F Y', strtotime($submission->created_at))}}</th>
                    <th colspan="3">Status : {{$submission->status}} ({{ $submission->step == 1 ? 'Sarpras' : ($submission->step == 2 ? 'Kepala Sekolah' : 'Yayasan') }})</th>
                </tr>
                <tr>
                    <th rowspan="2" valign="center">No.</th>
                    <th rowspan="2">Nama Barang</th>
                    <th rowspan="2">Waktu diperlukan</th>
                    <th rowspan="2">Keperluan</th>
                    <th rowspan="2">Tempat</th>
                    <th rowspan="2">Qty</th>
                    <th colspan="3" class="text-center">Taksiran Harga</th>
                </tr>
                <tr>
                    <th>Harga Satuan</th>
                    <th>Harga Ongkir</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submission->submission_detail as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-nowrap">{{ $detail->facility->name }} <small>({{ $detail->facility->brand }} | {{ $detail->facility->description }})</small></td>
                    <td class="text-nowrap">{{ date('d F Y', strtotime($detail->date_required)) }}</td>
                    <td>{{ $detail->necessity }}</td>
                    <td>{{ $detail->room->name }}</td>
                    <td clas="text-center">{{ $detail->qty }}</td>
                    <td class="text-nowrap">Rp {{ number_format($detail->price) }}</td>
                    <td class="text-nowrap">Rp {{ number_format($detail->postage_price) }}</td>
                    <td class="text-nowrap">Rp {{ number_format($detail->total_price) }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="8">Total Harga Keseluruhan :</th>
                    <th>Rp {{ number_format($total_price) }}</th>
                </tr>
            </tbody>
        </table>
        <div class="non-print py-2 text-end">
            <a href="{{ route('app.submission.index') }}" class="btn btn-sm btn-danger">
                <i class="ri ri-arrow-left-line"></i>
            </a>
            <button onclick="document.title='Invoice_{{ $submission->invoice }}'; window.print();return false;" class="btn btn-sm btn-primary">Print</button>
        </div>
    </div>
</div>
@stop