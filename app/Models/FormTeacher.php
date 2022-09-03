<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTeacher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'classroom_id', 'expertise_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class);
    }
}
