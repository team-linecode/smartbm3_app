<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAbsent extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        if ($this->status == 's') {
            return "Sakit";
        } else if ($this->status == 'i') {
            return "Izin";
        } else if ($this->status == 'a') {
            return "Alpha";
        }
    }
}
