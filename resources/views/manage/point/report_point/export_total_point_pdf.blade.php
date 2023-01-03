<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Poin Siswa</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <h4 style="text-align: center">Laporan Poin Siswa</h4>
    <h5 style="text-align: center">{{ date('d M Y', strtotime($from_date)) }} - {{ date('d M Y', strtotime($to_date)) }}
    </h5>
    <h5 style="text-align: center">Kelas : {{ $classrooms }} | Jurusan : {{ $expertises }}</h5>

    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%">
        <tr style="background-color: #e6e6e6">
            <th>NO</th>
            <th>NAMA</th>
            <th>KELAS</th>
            <th>TOTAL POIN</th>
        </tr>
        @php($no = 1)
        @forelse ($data['user_points'] as $user_point)
            <tr>
                <td style="text-align: center;">{{ $no++ }}</td>
                <td>{{ $user_point['name'] }}</td>
                <td style="text-align: center">{!! str_replace(' ', '&nbsp;', $user_point['classroom']) !!}</td>
                @if ($user_point['point'] > 0)
                    <td style="text-align: center; background-color: yellow;">{{ $user_point['point'] }}</td>
                @else
                    <td style="text-align: center; background-color: lightgreen;">{{ $user_point['point'] }}</td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center">Tidak ada data!</td>
            </tr>
        @endforelse
    </table>
</body>

</html>
