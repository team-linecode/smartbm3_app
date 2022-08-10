<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'alias'];

    public function costs()
    {
        return $this->belongsToMany(Cost::class, 'cost_classroom');
    }

    public function details($cost_id)
    {
        return CostDetail::where('classroom_id', $this->id)
            ->where('cost_id', $cost_id)
            ->get();
    }
}
