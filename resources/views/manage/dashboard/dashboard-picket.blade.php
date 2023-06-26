@extends('layouts.manage', ['title' => 'Dashboard'])

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"><i class="ri-line-chart-line align-middle"></i> Grafik Ketidakhadiran Siswa</h5>
    </div>
    <div class="card-header">
        <form method="get">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3 mb-md-0 mb-lg-0 mb-xl-0">
                        <label for="penalty">Dari Tanggal</label>
                        <input type="date" class="form-control @error('from_date') is-invalid @enderror"
                            name="from_date" id="from_date" value="{{ request()->get('from_date') ?? '' }}" required>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3 mb-md-0 mb-lg-0 mb-xl-0">
                        <label for="penalty">Sampai Tanggal</label>
                        <input type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date"
                            id="to_date" value="{{ request()->get('to_date') ?? '' }}" required>
                    </div>
                </div>
                <div class="col-lg-4 align-self-end">
                    <div class="d-flex">
                        <button class="btn btn-primary w-100 me-2">Tampilkan</button>
                        <a href="{{ route('app.dashboard.index') }}" class="btn btn-danger w-100">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <canvas id="barchart" class="chartjs" height="auto"></canvas>
    </div>
</div>
@stop

@push('include-script')
    @include('component.chartjs')

    <script>
        const data = {
            datasets: [{
                label: 'Sakit',
                data: {{ Js::from($data['sakit'] ?? []) }},
                backgroundColor: [
                  'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                  'rgb(75, 192, 192)',
                ],
                borderWidth: 1
            },
            {
                label: 'Izin',
                data: {{ Js::from($data['izin'] ?? []) }},
                backgroundColor: [
                  'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                  'rgb(255, 159, 64)',
                ],
                borderWidth: 1
            },
            {
                label: 'Alfa',
                data: {{ Js::from($data['alfa'] ?? []) }},
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                  'rgb(255, 99, 132)',
                ],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
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
        var ctx = document.getElementById("barchart");
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