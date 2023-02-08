<?php

namespace App\Models\Sarpras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionDetail extends Model
{
    use HasFactory;
    protected $fillable = ['submission_id', 'facility_id', 'facility_name', 'room_id', 'date_required', 'qty', 'price', 'postage_price', 'total_price', 'necessity'];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
    
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
