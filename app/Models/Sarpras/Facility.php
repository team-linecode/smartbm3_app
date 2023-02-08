<?php

namespace App\Models\Sarpras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomFacility;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brand', 'description'];
    
    function f_total(){
        $good = RoomFacility::where('facility_id', $this->id)->sum('good');
        $bad = RoomFacility::where('facility_id', $this->id)->sum('bad');
        $broken_can_repaired = RoomFacility::where('facility_id', $this->id)->sum('broken_can_repaired');
        $broken_cant_repaired = RoomFacility::where('facility_id', $this->id)->sum('broken_cant_repaired');
        return $good + $bad + $broken_can_repaired + $broken_cant_repaired;
    }
}
