<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyPoint extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'point', 'used', 'penalty_category_id'];

    public function category()
    {
        return $this->belongsTo(PenaltyCategory::class, 'penalty_category_id');
    }

    public function user_points()
    {
        return $this->hasMany(UserPoint::class, 'penalty_id')->where('type', 'plus');
    }
}
