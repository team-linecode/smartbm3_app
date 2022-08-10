<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bukti Pembayaran</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <style>
        body {
            width: 21cm;
            height: 29.7cm;
            padding: 1cm;
        }

        .header .title {
            font-size: 16px;
            font-family: serif;
        }

        .header .subtitle {
            font-size: 12px;
            font-family: serif;
        }

        .header .text-01 {
            font-size: 16px;
        }

        .header .text-02 {
            font-size: 12px;
        }

        .table {
            font-size: 12px;
        }

        .note {
            width: 100%;
            height: 81px;
            padding: 5px;
            line-height: 13px;
            border: 1px solid #dee2e6;
            font-size: 12px;
            overflow: hidden;
        }

        .signature-box {
            display: inline-block;
            width: 170px;
            height: 50px;
            border-bottom: 1px solid #dee2e6;
        }

        .small {
            font-size: 12px !important;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header d-flex justify-content-between mb-3">
        <div>
            <div class="d-flex align-items-center">
                <img src="{{ Storage::url('logo/bm3.png') }}" class="me-2" width="50">
                <div>
                    <div class="subtitle mb-0">YAYASAN BINA PERTIWI MANDIRI</div>
                    <div class="title mb-0 fw-bold">SMK BINA MANDIRI MULTIMEDIA</div>
                </div>
            </div>
        </div>
        <div>
            <h5 class="text-01 fw-bold text-end mb-1">BUKTI PEMBAYARAN</h5>
            <div class="text-02">
                <span class="me-3"><b>Tanggal:</b> {{ date('d/m/Y', strtotime($transaction->date)) }}</span>
                <span><b>Invoice ID:</b> {{ $transaction->invoice_id }}</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th width="30%">NAMA</th>
                        <th width="1%">:</th>
                        <td>{{ $transaction->user->name }}</td>
                    </tr>
                    <tr>
                        <th width="30%">NIS / NISN</th>
                        <th width="1%">:</th>
                        <td>{{ $transaction->user->nisn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th width="30%">JURUSAN</th>
                        <th width="1%">:</th>
                        <td>{{ $transaction->user->expertise->alias }}</td>
                    </tr>
                    <tr>
                        <th width="30%">KELAS</th>
                        <th width="1%">:</th>
                        <td>{{ $transaction->user->alumni == 0 ? $transaction->user->classroom->name : 'Alumni' }}</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-6">
            <h6>Keterangan :</h6>
            <div class="note">
                {{ $transaction->note ?? '-' }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h6>Rincian Transaksi</h6>
            <table class="table table-bordered table-sm">
                <thead class="text-center table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>RINCIAN</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    @php($total = 0)
                    @foreach ($transaction->details->sortBy('cost_detail_id') as $trx_detail)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}.</td>
                            <td>{{ $trx_detail->cost_detail->cost->name }} [detail: {{ $trx_detail->cost_detail_by_category($trx_detail->cost_detail->id, $trx_detail->cost_detail->cost->id) }}] [bulan: {{ $trx_detail->date ? strftime('%B %Y', strtotime($trx_detail->date)) : '-' }}]</td>
                            <td class="text-end">Rp. {{ number_format($trx_detail->amount, '0', '0', '.') }}</td>
                        </tr>
                        @php($total += $trx_detail->amount)
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td class="text-end" colspan="2"><b>TOTAL</b></td>
                        <td class="text-end fw-bold">Rp. {{ number_format($total, '0', '0', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-end" colspan="2"><b>METODE PEMBAYARAN</b></td>
                        <td class="text-end fw-bold">{{ $transaction->payment_method->account }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="signature-box"></div>
            <div class="small"><i>Cap / Tanda Tangan Bendahara</i></div>
            <div class="small text-danger"><i>* Uang yang sudah disetor tidak dapat dikembalikan</i></div>
        </div>
        <div class="col-6 text-end">
            <div class="signature-box"></div>
            <div class="small"><i>Nama & Tanda Tangan Penyetor</i></div>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
