<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanMember extends Model
{
    use HasFactory;
    protected $fillable = ['classroom_id', 'expertise_id', 'qrcode'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class);
    }
}
