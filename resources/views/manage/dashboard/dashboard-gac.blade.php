@extends('layouts.manage', ['title' => 'Dashboard'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Grafik Poin Pelanggaran Siswa</h5>
        </div>
        <div class="card-header">
            <form method="get">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="penalty">Pelanggaran</label>
                        <select class="form-select select2 @error('penalty') is-invalid @enderror" name="penalty"
                            id="penalty" required>
                            <option value="">Pilih Pelanggaran</option>
                            <option value="all" {{ select_old('all', request()->get('penalty')) }}>Semua</option>
                            @foreach ($penalty_points as $penalty_point)
                                <option value="{{ $penalty_point->id }}"
                                    {{ select_old($penalty_point->id, request()->get('penalty')) }}>
                                    {{ $penalty_point->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="penalty">Dari Tanggal</label>
                        <input type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date"
                            id="from_date" value="{{ request()->get('from_date') ?? '' }}" required>
                    </div>
                    <div class="col-lg-3">
                        <label for="penalty">Sampai Tanggal</label>
                        <input type="date" class="form-control @error('to_date') is-invalid @enderror" name="to_date"
                            id="to_date" value="{{ request()->get('to_date') ?? '' }}" required>
                    </div>
                    <div class="col-lg-3 align-self-end">
                        @if (request()->get('penalty') || request()->get('from_date') || request()->get('to_date'))
                            <a href="{{ route('app.dashboard.index') }}" class="btn btn-danger w-100">Reset</a>
                        @else
                            <button class="btn btn-primary w-100">Tampilkan</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <canvas id="linechart" class="chartjs" width="undefined" height="100"></canvas>
        </div>
    </div>
@stop

@push('include-script')
    @include('component.chartjs')

    <script>
        const labels = [
            "1 Jan", "2 jan", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
            "November", "Desember"
        ];
        const data = {
            labels: labels,
            datasets: [{
                label: 'Data Pelanggaran Siswa',
                data: [65, 9, 80, 81, 56, 55, 40, 40, 40, 40, 40, 40],
                fill: false,
                borderColor: 'rgb(64, 81, 137)',
                tension: 0.3
            }]
        };
        const config = {
            type: 'line',
            data: data
        };
        var ctx = document.getElementById("linechart");
        const myChart = new Chart(ctx, config);
    </script>
@endpush
