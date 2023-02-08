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
    @foreach($expertises as $expertise)
        <table border="1" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="{{ ($total_day + 6) }}" style="text-align: center; font-size: 9px; padding: 5px 0;">{{ $classroom->name }} {{ $expertise->name }} | {{ monthID(date('n', strtotime($date))) }} {{ date('Y', strtotime($date)) }}</td>
            </tr>
            <tr>
                <th style="font-size: 9px; padding: 0 5px;">No</th>
                <th style="font-size: 7px">Nama</th>
                @foreach(range(1, $total_day) as $day)
                <th width="17" style="background-color: #dedede; font-size: 9px; padding: 10px 0;">{{ $day }}</th>
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
                @foreach(range(1, $total_day) as $day)
                <td align="center" style="font-size: 9px; background-color: {{ $student->checkAbsentStatusColor( date('Y-m-', strtotime($date)) . $day ) }}">{{ strtoupper($student->checkAbsentStatus( date('Y-m-', strtotime($date)) . $day )) }}</td>
                @endforeach
                <td align="center" style="background-color: #cefad0; font-size: 9px;">{{ $student->getTotalAbsentByStatus('s', $date) }}</td>
                <td align="center" style="background-color: #cefad0; font-size: 9px;">{{ $student->getTotalAbsentByStatus('i', $date) }}</td>
                <td align="center" style="background-color: #cefad0; font-size: 9px;">{{ $student->getTotalAbsentByStatus('a', $date) }}</td>
                <td align="center" style="background-color: #cefad0; font-size: 9px;">{{ $student->getTotalAbsent($date) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ ($total_day + 6) }}" style="text-align: center; font-size: 9px; padding: 5px 0;">Tidak Ada Siswa!</td>
            </tr>
            @endforelse
        </table>
        <br>
        <br>
    @endforeach
</body>
</html>
