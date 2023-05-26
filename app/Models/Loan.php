<?php

namespace App\Models;

use App\Models\Sarpras\Facility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'loan_date', 'estimation_return_date', 'return_date'];

    public function member()
    {
        return $this->belongsTo(LoanMember::class, 'loan_member_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    public function approvers()
    {
        return $this->hasMany(LoanApprover::class);
    }

    public function status()
    {
        $total_approvers = $this->approvers()->count();
        $status_pending  = $this->approvers()->where('status', 'pending')->count();
        $status_accept   = $this->approvers()->where('status', 'accept')->count();
        $status_reject   = $this->approvers()->where('status', 'reject')->count();

        if ($this->return_date == null) {
            if ($status_pending > 0) {
                return "Pending";
            } else if ($status_accept == $total_approvers) {
                return "In Use";
            } else if ($status_reject > 0) {
                return "Reject";
            }
        } else {
            return "Finished Use";
        }
    }
}
