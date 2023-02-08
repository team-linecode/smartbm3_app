<!DOCTYPE html>
<html>

<head>
    <title>Laporan Ketidakhadiran | {{ dayID(date('N')) }}, {{ date('d F Y') }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }

        #results {
            border-collapse: collapse;
            width: 100%;
        }

        #results td,
        #results th {
            border: 1px solid #ddd;
            padding: 5px;
            vertical-align: top;
        }

        #results tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #results tr:hover {
            background-color: #ddd;
        }

        #results th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #208780;
            color: white;
        }

        #btnprint {
            width: 100px;
            height: 30px;
            margin-bottom: 30px;
        }

        @media print {
            #btnprint {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div style="overflow: auto">
        <div style="text-align: center;">
            <b>Laporan Ketidakhadiran</b><br>
            {{ dayID(date('N')) }}, {{ date('d') }} {{ monthID(date('m')) }} {{ date('Y') }}
        </div>
        <br>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr style="background-color: #ececec;">
                <th style="text-align: left;">Guru Piket</th>
            </tr>
            <tr>
                <td>
                    <ol>
                        @foreach ($data['picket_schedule']->users as $user)
                            <li>{{ $user->name }}</li>
                        @endforeach
                    </ol>
                </td>
            </tr>
        </table>
        <br>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr style="background-color: #ececec;">
                <th style="text-align: left;">Guru Tidak Hadir</th>
            </tr>
            <tr>
                <td>
                    @if (count($data['teacher_absents']) > 0)
                        <ol>
                            @foreach ($data['teacher_absents'] as $teacher_absent)
                                <li>{{ ucwords(strtolower($teacher_absent->user->name)) }} ({{ $teacher_absent->status() }})</li>
                            @endforeach
                        </ol>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
        <br>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr style="background-color: #ececec;">
                <th colspan="2" style="text-align: left">Laporan Ketidakhadiran Siswa</th>
            </tr>
            <tr>
                <th>Kelas</th>
                <th>Siswa Tidak Hadir</th>
            </tr>
            @foreach ($data['classrooms'] as $classroom)
                @foreach ($data['expertises'] as $expertise)
                    <tr>
                        <td width="15%"><b>{{ $classroom->name . ' ' . $expertise->name }}</b></td>
                        <td>
                            @if ($data['students']->where('user.classroom_id', $classroom->id)->where('user.expertise_id', $expertise->id)->count() > 0)
                                <ol>
                                    @foreach ($data['students']->where('user.classroom_id', $classroom->id)->where('user.expertise_id', $expertise->id) as $presence)
                                        <li>
                                            {{ ucwords(strtolower($presence->user->name)) }}
                                            ({{ $presence->status() }})
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
        <br>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr style="background-color: #ececec;">
                <th colspan="2" style="text-align: left">Laporan Keterlambatan Siswa</th>
            </tr>
            <tr>
                <th>Kelas</th>
                <th>Siswa Terlambat</th>
            </tr>
            @foreach ($data['classrooms'] as $classroom)
                @foreach ($data['expertises'] as $expertise)
                    <tr>
                        <td width="15%"><b>{{ $classroom->name . ' ' . $expertise->name }}</b></td>
                        <td>
                            @if ($data['latest']->where('user.classroom_id', $classroom->id)->where('user.expertise_id', $expertise->id)->count() > 0)
                                <ol>
                                    @foreach ($data['latest']->where('user.classroom_id', $classroom->id)->where('user.expertise_id', $expertise->id) as $presence)
                                        <li>{{ ucwords(strtolower($presence->user->name)) }} ({{ date('H:i', strtotime($presence->date)) }}) ({{ ucfirst($presence->user->total_points()) }} Point)</li>
                                    @endforeach
                                </ol>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
        <br>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr style="background-color: #ececec;">
                <th colspan="2" style="text-align: left">Laporan Siswa PKL</th>
            </tr>
            <tr>
                <th>Kelas</th>
                <th>Siswa PKL</th>
            </tr>
            @foreach ($data['classrooms'] as $classroom)
                @foreach ($data['expertises'] as $expertise)
                    <tr>
                        <td width="15%"><b>{{ $classroom->name . ' ' . $expertise->name }}</b></td>
                        <td>
                            @if ($data['student_apprenticeships']->where('user.classroom_id', $classroom->id)->where('user.expertise_id', $expertise->id)->count() > 0)
                                <ol>
                                    @foreach ($data['student_apprenticeships']->where('user.classroom_id', $classroom->id)->where('user.expertise_id', $expertise->id) as $student_apprenticeship)
                                        <li>
                                            {{ ucfirst($student_apprenticeship->user->name) }}
                                            @if ($student_apprenticeship->start_date != null && $student_apprenticeship->end_date != null)
                                                ({{ date('d/m/Y', strtotime($student_apprenticeship->start_date)) }} -
                                                {{ date('d/m/Y', strtotime($student_apprenticeship->end_date)) }})
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>

    </div>

</body>

</html>
