<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['achievement_id', 'file', 'format', 'size'];
}
