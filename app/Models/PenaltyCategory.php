<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyCategory extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name'];

    public function points()
    {
        return $this->hasMany(PenaltyPoint::class);
    }
}
