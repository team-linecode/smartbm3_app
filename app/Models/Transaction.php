<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_no', 'invoice_id', 'total', 'status', 'date', 'note', 'user_id', 'payment_method_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        if ($this->status == 'Pending') {
            $status = '<span class="text-warning"><i class="ri-time-line align-middle"></i> ' . $this->status . '</span>';
        } else if ($this->status == 'Paid') {
            $status = '<span class="text-success"><i class="ri-checkbox-circle-line align-middle"></i> ' . $this->status . '</span>';
        } else if ($this->status == 'Unpaid') {
            $status = '<span class="text-danger"><i class="ri-bill-line align-middle"></i> ' . $this->status . '</span>';
        } else if ($this->status == 'Refund') {
            $status = '<span class="text-danger"><i class="ri-refund-2-line align-middle"></i> ' . $this->status . '</span>';
        } else {
            $status = '<span class="text-danger"><i class="ri-close-circle-line align-middle"></i> ' . $this->status . '</span>';
        }

        return $status;
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
