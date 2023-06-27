<div class="persentages d-none mt-2">
    <div class="d-flex align-items-center">
        <div class="me-2">Nominal</div>
        <div>
            <button type="button" class="btn btn-sm btn-outline-primary py-0 rounded-pill cost-percentage"
                data-percentage="25" data-amount="{{ auth()->user()->transaction_history($cost_detail->id)['remaining'] }}">25%</button>
            <button type="button" class="btn btn-sm btn-outline-primary py-0 rounded-pill cost-percentage"
                data-percentage="50" data-amount="{{ auth()->user()->transaction_history($cost_detail->id)['remaining'] }}">50%</button>
            <button type="button" class="btn btn-sm btn-outline-primary py-0 rounded-pill cost-percentage"
                data-percentage="75" data-amount="{{ auth()->user()->transaction_history($cost_detail->id)['remaining'] }}">75%</button>
            <button type="button" class="btn btn-sm btn-outline-primary py-0 rounded-pill cost-percentage"
                data-percentage="100" data-amount="{{ auth()->user()->transaction_history($cost_detail->id)['remaining'] }}">100%</button>
        </div>
    </div>
</div>
