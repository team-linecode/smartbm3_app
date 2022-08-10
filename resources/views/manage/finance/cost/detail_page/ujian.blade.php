<div class="card">
    <div class="card-header">
        <h4 class="card-title text-center text-uppercase mb-0">Biaya Setiap Semester</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-nowrap text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="w-50">Semester</th>
                        <th scope="col" class="w-50">Jumlah (Rp.)</th>
                    </tr>
                </thead>
                <tbody>
                    @php($total = 0)
                    @foreach($cost->details as $cost_detail)
                    <tr>
                        <td><span class="fw-medium">{{ $cost_detail->semester->alias }}</span> <span class="text-muted">({{ $cost_detail->semester->type }})</span></td>
                        <td>Rp. {{ number_format($amount = $cost_detail->amount) }}</td>
                    </tr>
                    @php($total += $amount)
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="2" class="text-center">Total : Rp. {{ number_format($total) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
