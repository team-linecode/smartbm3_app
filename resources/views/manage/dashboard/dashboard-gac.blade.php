@extends('layouts.manage', ['title' => 'Dashboard'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-primary mb-0"><i class="ri-alert-line align-middle"></i> 5 Pelanggaran yang
                        sering dilanggar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table mb-0">
                            <tbody>
                                @forelse ($penalty_points->where('used', '!=', 0)->sortByDesc('used')->take(5) as $penalty_point)
                                    <tr>
                                        <td class="text-muted">{{ $penalty_point->name }}</td>
                                        <td class="fw-medium">{{ $penalty_point->used }}x&nbsp;dilanggar</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">Tidak ada data!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-primary mb-0"><i class="ri-group-line"></i> 5 Siswa yang sering melanggar
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table mb-0">
                            <tbody>
                                @forelse ($top_students as $top_student)
                                    <tr>
                                        <td class="text-muted">{{ $top_student->name }}</td>
                                        <td class="text-muted">{!! str_replace(' ', '&nbsp;', $top_student->myClass()) !!}</td>
                                        <td class="fw-medium">{{ $top_student->user_points_count }}&nbsp;Pelanggaran</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">Tidak ada data!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ri-line-chart-line align-middle"></i> Grafik Poin Pelanggaran Siswa</h5>
        </div>
        <div class="card-header">
            <form method="get">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0 mb-xl-0">
                            <label for="penalty">Pelanggaran</label>
                            <select class="form-select select2 @error('penalty') is-invalid @enderror" name="penalty"
                                id="penalty" required>
                                <option value="">Pilih Pelanggaran</option>
                                <option value="all" {{ select_old('all', request()->get('penalty')) }}>Semua</option>
                                @foreach ($penalty_categories as $penalty_category)
                                    <optgroup label="POIN {{ $penalty_category->code }}">
                                        @foreach ($penalty_category->points as $penalty_point)
                                    <optgroup label="{{ $penalty_point->code }}">
                                        <option value="{{ $penalty_point->id }}"
                                            {{ select_old($penalty_point->id, request()->get('penalty')) }}>
                                            {{ $penalty_point->name }}
                                        </option>
                                    </optgroup>
                                @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0 mb-xl-0">
                            <label for="penalty">Dari Tanggal</label>
                            <input type="date" class="form-control @error('from_date') is-invalid @enderror"
                                name="from_date" id="from_date" value="{{ request()->get('from_date') ?? '' }}" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3 mb-md-0 mb-lg-0 mb-xl-0">
                            <label for="penalty">Sampai Tanggal</label>
                            <input type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date"
                                id="to_date" value="{{ request()->get('to_date') ?? '' }}" required>
                        </div>
                    </div>
                    <div class="col-lg-3 align-self-end">
                        <div class="d-flex">
                            <button class="btn btn-primary w-100 me-2">Tampilkan</button>
                            <a href="{{ route('app.dashboard.index') }}" class="btn btn-danger w-100">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <canvas id="linechart" class="chartjs" height="auto"></canvas>
        </div>
    </div>
@stop

@push('include-script')
    @include('component.chartjs')

    <script>
        const labels = [{!! isset($chart['labels']) ? $chart['labels'] : '' !!}];
        const data = {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pelanggaran',
                data: [{!! $chart['datas'] ?? '' !!}],
                fill: false,
                borderColor: 'rgb(64, 81, 137)',
                borderWidth: 1.5,
                pointBackgroundColor: 'orange',
                pointBorderColor: 'orange',
                tension: 0.3
            }]
        };
        const config = {
            type: 'line',
            data: data,
            options: {
                scales: {
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 20
                        }
                    },
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 10
                    }
                }
            }
        };
        var ctx = document.getElementById("linechart");
        const myChart = new Chart(ctx, config);
    </script>

    <script>
        $('#from_date').change(function() {
            let from_date = $(this).val()

            $('#to_date').attr('min', from_date)
        })

        $('#to_date').change(function() {
            let to_date = $(this).val()

            $('#from_date').attr('max', to_date)
        })
    </script>
@endpush
