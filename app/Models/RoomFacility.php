<?php

namespace App\Models;

use App\Models\Sarpras\Facility;
use App\Models\Sarpras\Room;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFacility extends Model
{
    use HasFactory;
    protected $fillable = ['room_id', 'facility_id', 'good', 'bad', 'broken_can_repaired', 'broken_cant_repaired', 'total'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
