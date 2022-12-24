<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'penalty_id', 'description', 'type', 'point', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penalty()
    {
        return  $this->belongsTo(PenaltyPoint::class);
    }

    public function date()
    {
        return strtotime($this->date);
    }
}
