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
    <h5 style="text-align: center">Kelas : {{ $classrooms->pluck('name')->implode(', ') }} | Jurusan : {{ $expertises->pluck('name')->implode(', ') }}</h5>

    @foreach($classrooms->get() as $classroom)
        @foreach($expertises->get() as $expertise)
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%">
            <tr style="background-color: #e6e6e6">
                <th colspan="4">{{ $classroom->name }} {{ $expertise->name }}</th>
            </tr>
            <tr style="background-color: #e6e6e6">
                <th>NO</th>
                <th>NAMA</th>
                <th>TOTAL POIN</th>
                <th>RINCIAN POIN</th>
            </tr>
            @php($no = 1)
            @forelse ($students->where('classroom_id', $classroom->id)->where('expertise_id', $expertise->id) as $student)
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td>{{ $student->name }}</td>
                    @if ($student->total_points() > 0)
                        <td style="text-align: center; background-color: yellow;">{{ $student->total_points() }}</td>
                    @else
                        <td style="text-align: center; background-color: lightgreen;">{{ $student->total_points() }}</td>
                    @endif
                    <td>
                        <ol>
                            @foreach($penalty_points->whereIn('id', $student->user_points->pluck('penalty_id')) as $penalty_point)
                                <li>{{ $penalty_point->name }} ({{ $student->user_points->where('penalty_id', $penalty_point->id)->count() }}x)</li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center">Tidak ada data!</td>
                </tr>
            @endforelse
        </table>
        <br>
        <br>
        @endforeach
    @endforeach
</body>

</html>
