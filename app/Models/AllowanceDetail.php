<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowanceDetail extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'last_education', 'allowance_id', 'salary'];

    public function lastEducation()
    {
        return $this->belongsTo(LastEducation::class);
    }
}
