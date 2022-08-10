<div class="card">
    <div class="card-header">
        <h4 class="card-title text-center text-uppercase mb-0">Biaya Setiap Kelas</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-nowrap text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Kelas</th>
                        <th scope="col">Jumlah (1 Bulan)</th>
                        <th scope="col">Jumlah (1 Tahun)</th>
                    </tr>
                </thead>
                <tbody>
                    @php($total_onemonth = 0)
                    @php($total_oneyear = 0)
                    @foreach($cost->details as $cost_detail)
                    <tr>
                        <td>{{ $cost_detail->classroom->name }}</td>
                        <td>Rp. {{ number_format($onemonth = $cost_detail->amount) }}</td>
                        <td>Rp. {{ number_format($oneyear = $cost_detail->amount * 12) }}</td>
                    </tr>
                    @php($total_onemonth += $onemonth)
                    @php($total_oneyear += $oneyear)
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="1">Total :</th>
                        <th>Rp. {{ number_format($total_onemonth) }}</th>
                        <th>Rp. {{ number_format($total_oneyear) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
