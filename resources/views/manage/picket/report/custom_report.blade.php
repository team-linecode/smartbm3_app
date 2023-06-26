<!DOCTYPE html>
<html>

<head>
    <title>Laporan Ketidakhadiran | {{ dayID(date('N')) }}, {{ date('d F Y') }}</title>
    <style>
        html {
            margin: 1rem;
            padding: 1rem;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">Laporan Piket Bulanan</div>
    <div style="text-align: center;"></div>
    <br>
    @php
        $total_sakit = 0;
        $total_izin = 0;
        $total_alfa = 0;
    @endphp
    @foreach($expertises as $expertise)
        @if ($students->where('expertise_id', $expertise->id)->count() > 0)
        <table border="1" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="{{ ($total_day + 6) }}" style="text-align: center; font-size: 9px; padding: 5px 0;">{{ $classroom->name }} {{ $expertise->name }} | {{ date('d F Y', strtotime($date1)) }} - {{ date('d F Y', strtotime($date2)) }}</td>
            </tr>
            <tr>
                <th width="5" style="font-size: 9px; padding: 0 5px;">No</th>
                <th width="20" style="font-size: 7px">Nama</th>
                @foreach($period as $day)
                <th width="17" style="background-color: #dedede; font-size: 9px; padding: 10px 0;">{{ $day->format('d/m') }}</th>
                @endforeach
                <th width="17" style="font-size: 9px; background-color: lightskyblue">S</th>
                <th width="17" style="font-size: 9px; background-color: yellow">I</th>
                <th width="17" style="font-size: 9px; background-color: red">A</th>
                <th width="17" style="padding: 0 5px; font-size: 9px; background-color: #b19cd9">Total</th>
            </tr>
            @forelse($students->where('expertise_id', $expertise->id) as $student)
            <tr>
                <td align="center" style="font-size: 9px;">{{ $loop->iteration }}</td>
                <td style="padding: 5px 5px; font-size: 9px;">{{ ucwords(strtolower($student->name)) }}</td>
                @foreach($period as $day)
                <td align="center" style="font-size: 9px; background-color: {{ $student->checkAbsentStatusColor( $day->format('Y-m-d') ) }}">{{ strtoupper($student->checkAbsentStatus( $day->format('Y-m-d') )) }}</td>
                @endforeach
                <td align="center" style="background-color: #cefad0; font-size: 9px;">{{ $student->getTotalAbsentByStatus('s', $date1, $date2) }}</td>
                <td align="center" style="background-color: #cefad0; font-size: 9px;">{{ $student->getTotalAbsentByStatus('i', $date1, $date2) }}</td>
                <td align="center" style="background-color: #cefad0; font-size: 9px;">{{ $student->getTotalAbsentByStatus('a', $date1, $date2) }}</td>
                <td align="center" style="background-color: #cefad0; font-size: 9px;">{{ $student->getTotalAbsent($date1, $date2) }}</td>
                
                @php
                    $total_sakit += $student->getTotalAbsentByStatus('s', $date1, $date2);
                    $total_izin += $student->getTotalAbsentByStatus('i', $date1, $date2);
                    $total_alfa += $student->getTotalAbsentByStatus('a', $date1, $date2);
                @endphp
            </tr>
            @empty
            <tr>
                <td colspan="{{ ($total_day + 6) }}" style="text-align: center; font-size: 9px; padding: 5px 0;">Tidak Ada Siswa!</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="{{ ($total_day + 6) }}" style="font-size: 9px; padding: 5px 10px;">
                    Total ketidakhadiran pertanggal {{ date('d F Y', strtotime($date1)) }} - {{ date('d F Y', strtotime($date2)) }}<br>
                    <table border="0">
                        <tr>
                            <th style="text-align: left;">Sakit</th>
                            <th>:</th>
                            <td>{{ $total_sakit }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Izin</th>
                            <th>:</th>
                            <td>{{ $total_izin }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Alfa</th>
                            <th>:</th>
                            <td>{{ $total_alfa }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Total ketidakhadiran</th>
                            <th>:</th>
                            <td>{{ $total_sakit + $total_izin + $total_alfa }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        @endif
        <br>
        <br>
    @endforeach
</body>
</html>
