<div class="card">
    <div class="card-header">
        <h4 class="card-title text-center text-uppercase mb-0">Keterangan Biaya</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-nowrap text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Biaya</th>
                        <th scope="col" class="w-50">Jumlah (Rp.)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($cost->details as $cost_detail)
                        <td>{{ $cost->name }}</td>
                        <td>Rp. {{ number_format($cost_detail->amount) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
