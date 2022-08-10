<table class="table table-nowrap text-center mb-0">
    <thead class="table-light">
        <tr>
            <th scope="col">Jumlah (Rp.)</th>
            <th scope="col">Dibayarkan (Rp.)</th>
            <th scope="col">Sisa (Rp.)</th>
        </tr>
    </thead>
    <tbody>
        @php($total = 0)
        @php($paid = 0)
        @php($remaining = 0)

        @foreach($cost->cost_groups($user->group->id) as $cost_group)
        <tr>
            <td>Rp. {{ number_format($cost_amount = $cost_group->amount) }}</td>
            <td>Rp. {{ number_format($paid_amount = 150000) }}</td>
            <td>Rp. {{ number_format($remaining_amount = $cost_amount - $paid_amount) }}</td>
        </tr>

        @php($total += $cost_amount)
        @php($paid += $paid_amount)
        @php($remaining += $remaining_amount)
        @endforeach
    </tbody>
    <tfoot class="table-light">
        <tr>
            <th></th>
            <th>Rp. {{ number_format($paid) }}</th>
            <th>Rp. {{ number_format($remaining) }}</th>
        </tr>
    </tfoot>
</table>