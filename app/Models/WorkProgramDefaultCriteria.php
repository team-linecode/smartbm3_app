<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkProgramDefaultCriteria extends Model
{
    use HasFactory;
    protected $fillable = ['work_program_default_id', 'value_criteria_id'];
}
