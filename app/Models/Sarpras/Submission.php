<?php

namespace App\Models\Sarpras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Submission extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'invoice', 'note', 'step', 'status'];

    public function submission_detail()
    {
        return $this->hasMany(SubmissionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
