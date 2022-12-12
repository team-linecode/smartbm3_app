<?php

namespace App\Models\Sarpras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'stage', 'building_id'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
