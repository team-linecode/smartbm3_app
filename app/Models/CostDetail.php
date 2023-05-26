<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostDetail extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'cost_id', 'classroom_id', 'group_id', 'semester_id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function category()
    {
        return $this->cost->cost_category;
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function cost()
    {
        return $this->belongsTo(Cost::class);
    }

    public function markTransactionExists($user_id, $data, $callback)
    {
        $transaction = TransactionDetail::where('cost_detail_id', $this->id)
            ->where('date', $data)
            ->whereHas('transaction', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->first();

        if ($transaction && $this->cost->cost_category->slug == 'spp') {
            return $callback;
        } else {
            return '';
        }
    }
}
