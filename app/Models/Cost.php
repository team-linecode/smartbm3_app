<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'schoolyear_id', 'cost_category_id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function schoolyear()
    {
        return $this->belongsTo(Schoolyear::class);
    }

    public function cost_category()
    {
        return $this->belongsTo(CostCategory::class);
    }

    public function details()
    {
        return $this->hasMany(CostDetail::class);
    }

    public function getSemesterByClass()
    {
        $user = User::findOrFail(auth()->user()->id);

        if ($user->classroom->alias == '10') {
            return ['1', '2'];
        } else if ($user->classroom->alias == '11') {
            return ['1', '2', '3', '4'];
        } else if ($user->classroom->alias == '12') {
            return ['1', '2', '3', '4', '5', '6'];
        }
    }

    public function cost_groups($group_id)
    {
        return CostDetail::where('cost_id', $this->id)
            ->where('group_id', $group_id)
            ->get();
    }

    public function get_detail_by_group($group_id)
    {
        return $this->details->where('group_id', $group_id)->first();
    }
}
