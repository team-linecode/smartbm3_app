<div class="card">
    <div class="card-header">
        <h4 class="card-title text-center text-uppercase mb-0">Biaya Setiap Gelombang</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-nowrap text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="w-50">Gelombang</th>
                        <th scope="col" class="w-50">Jumlah (Rp.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cost->details as $cost_detail)
                    <tr>
                        <td>{{ $cost_detail->group->alias }}</td>
                        <td>Rp. {{ number_format($cost_detail->amount) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
