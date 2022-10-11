<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Slip Gaji {{ date('F Y', strtotime($data['salary']['month'])) }}</title>

    <style type="text/css">
        @page {
            margin: 3rem 4rem 3rem 3rem;
        }

        body {
            font-size: small;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .section-01 {
            /* border: 1px solid black;
            width: 100%;
            padding: 0.5rem; */
        }

        .section-01 .title-01 {
            font-style: 16px;
            text-align: center;
            font-weight: bold;
        }

        .section-01 .table-01 tr td:nth-child(1) {
            padding-right: 20px
        }

        .section-01 .table-02 {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .section-01 .title-02 {
            border: 1px solid #000;
            font-style: 16px;
            text-align: center;
            font-weight: bold;
            margin-top: 1rem;
        }

        .section-01 .title-03 {
            width: 100%;
            text-align: center;
            margin-bottom: 2rem;
        }

        .section-01 .table-03 {
            width: 100%;
        }

        .section-01 .table-03 tr td {
            border-bottom: 1px dotted #000;
        }

        .section-01 .table-03 tr td:nth-child(3) {
            font-weight: bold
        }

        .section-01 .table-04 {
            width: 100%;
        }

        .section-01 .table-05 {
            width: 100%;
        }

        .section-01 .table-05 tr th {
            border-bottom: 1px solid #000;
        }

        .section-01 .table-05 tr th:nth-child(3) {
            font-weight: bold
        }

        .section-01 .table-06 {
            width: 100%;
        }

        .note {
            background-color: yellow;
            margin-top: 0.5rem;
            padding: 0 5px;
        }

        .net-salary {
            border: 1px solid #000;
            font-style: 16px;
            text-align: center;
            font-weight: bold;
            margin-top: 0.7rem;
            margin-bottom: 1rem;
        }

        .net-salary .text-01 {
            margin-right: 10rem;
        }
    </style>
</head>

<body>
    <section class="section-01">
        <div class="title-01">SLIP GAJI - SMK BM3</div>
        <br>
        <table class="table-01">
            <tr>
                <td>NIK/NIY</td>
                <td>: {{ !is_null($data['user']['nip']) ? $data['user']['nip'] : 0 }}</td>
            </tr>
            <tr>
                <td>NAMA</td>
                <td>: {{ $data['user']['name'] }}</td>
            </tr>
            <tr>
                <td>JABATAN</td>
                <td>:
                    @if ($data['role']['name'] == 'teacher')
                        Guru,
                    @endif

                    @foreach ($data['positions'] as $indexPosition => $position)
                        @if ($indexPosition == 0)
                            {{ $position['name'] }}
                        @else
                            , {{ $position['name'] }}
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>STATUS/GOL</td>
                <td>: {{ $data['user']['status'] ?? '0' }}</td>
            </tr>
            <tr>
                <td>PENDIDIKAN</td>
                <td>: {{ $data['last_education'] ? $data['last_education']['alias'] : '-' }}</td>
            </tr>
            <tr>
                <td>BULAN</td>
                <td>: {{ date('F Y', strtotime($data['salary']['month'])) }}</td>
            </tr>
        </table>

        <table class="table-02">
            <tr>
                <td>
                    <div class="title-02">PENERIMAAN</div>
                </td>
                <td>
                    <div class="title-02"><span style="opacity: 0;">N</span>POTONGAN<span style="opacity: 0;">N</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <table class="table-03">
                        @php
                            $total_allowance = 0;
                        @endphp
                        @foreach ($data['components']['allowances'] as $allowance)
                            <tr>
                                <td style="width: 50%">{{ $allowance['name'] }}</td>
                                <td>:</td>
                                <td align="right">
                                    @if ($allowance['amount'] != 0)
                                        Rp {{ number_format($allowance['amount'], 0, '.', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>

                            @php
                                $total_allowance += $allowance['amount'];
                            @endphp
                        @endforeach
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table class="table-03">
                        @php
                            $total_salaryCuts = 0;
                        @endphp
                        @foreach ($data['components']['salary_cuts'] as $salary_cut)
                            <tr>
                                <td style="width: 50%">{{ $salary_cut['name'] }}</td>
                                <td>:</td>
                                <td align="right">
                                    @if ($salary_cut['amount'] != 0)
                                        Rp {{ number_format($salary_cut['amount'], 0, '.', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>

                            @php
                                $total_salaryCuts += $salary_cut['amount'];
                            @endphp
                        @endforeach
                    </table>

                    <div class="note">
                        Ket :* Diberikan Bila Kehadiran Full Dan Tidak Ada Keterlambatan
                    </div>
                </td>
            </tr>
        </table>

        <table class="table-04">
            <tr>
                <td style="width: 50%">
                    <table class="table-05">
                        <tr align="left">
                            <th style="width: 50%">Total</th>
                            <th>Rp</th>
                            <th align="right">{{ number_format($total_allowance, 0, '.', '.') }}</th>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%">
                    <table class="table-05">
                        <tr align="left">
                            <th style="width: 50%">Total</th>
                            <th>Rp</th>
                            <th align="right">{{ number_format($total_salaryCuts, 0, '.', '.') }}</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="table-06">
            <tr>
                <td style="width: 50%">

                </td>
                <td style="width: 50%">
                    <div class="net-salary">
                        <span class="text-01">
                            Gaji Bersih
                        </span>
                        <span class="text-02">
                            Rp. {{ number_format($total_allowance + $total_salaryCuts, 0, '.', '.') }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        <table class="table-02">
            <tr>
                <td>
                    <div class="title-03">Kepsek</div>
                </td>
                <td>
                    <div class="title-03">Keuangan</div>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
