<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'month', 'cost_detail_id', 'transaction_id'];

    public function cost_detail()
    {
        return $this->belongsTo(CostDetail::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function cost_detail_by_category($cost_detail_id, $cost_id)
    {
        $cost = Cost::find($cost_id);

        if ($cost->cost_category->slug == 'spp' || $cost->cost_category->slug == 'daftar-ulang') {
            return 'Kelas ' . CostDetail::find($cost_detail_id)->classroom->alias;
        } else if ($cost->cost_category->slug == 'ujian') {
            return CostDetail::find($cost_detail_id)->semester->alias;
        } else if ($cost->cost_category->slug == 'gedung') {
            return '-';
        } else {
            return '-';
        }
    }
}
