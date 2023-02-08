<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionUser extends Model
{
    use HasFactory;
    protected $table = 'position_user';

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
