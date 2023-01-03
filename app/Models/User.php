<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nip',
        'nisn',
        'username',
        'email',
        'password',
        'no_encrypt',
        'image',
        'gender',
        'marital_status',
        'child',
        'group_id',
        'schoolyear_id',
        'alumni',
        'entry_date',
        'status',
        'last_education_id',
        'role_id',
        'classroom_id',
        'expertise_id',
        'verify_token',
        'expired_token',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_teacher')->withPivot('hours');
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }

    // public function hasPermission($permission)
    // {
    //     return $this->role->permissions()->where('name', $permission)->first() ?: false;
    // }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class);
    }

    public function schoolyear()
    {
        return $this->belongsTo(Schoolyear::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function last_education()
    {
        return $this->belongsTo(LastEducation::class);
    }

    public function myClass($alias = false)
    {
        return ($this->alumni == 0
            ? ($alias ? $this->classroom->alias . ' ' . $this->expertise->alias : $this->classroom->name . ' ' . $this->expertise->name)
            : '<span class="text-warning">Alumni</span>');
    }

    public function total_all_cost()
    {
        $total = 0;

        foreach ($this->schoolyear->costs as $cost) {
            $category = $cost->cost_category->slug;
            if ($category == 'spp') {
                foreach ($cost->details as $cost_detail) {
                    $total += $cost_detail->amount * 12;
                }
            } else if ($category == 'ujian' || $category == 'daftar-ulang') {
                foreach ($cost->details as $cost_detail) {
                    $total += $cost_detail->amount;
                }
            } else if ($category == 'lain-lain') {
                foreach ($cost->cost_groups($this->group->id) as $cost_detail) {
                    $total += $cost_detail->amount;
                }
            }
        }

        return $total;
    }

    public function total_all_paid()
    {
        return 0;
    }

    public function total_all_remaining()
    {
        return ($this->total_all_cost() - $this->total_all_paid());
    }

    public function photo()
    {
        if ($this->image == null) {
            return Storage::url('users/default/user.png');
        } else {
            return Storage::url($this->image);
        }
    }

    public function total_points($from_date = null, $to_date = null)
    {
        if ($from_date == null && $to_date == null) {
            $user_points = UserPoint::where('user_id', $this->id)->get();
        } else {
            $user_points = UserPoint::where('user_id', $this->id)->whereBetween('date', [$from_date . " 00:00:00", $to_date . " 23:59:59"])->get();
        }

        $total_points = 0;

        foreach ($user_points as $user_point) {
            if ($user_point->type == 'plus') {
                $total_points += $user_point->penalty->point;
            } else if ($user_point->type == 'minus') {
                $total_points -= $user_point->point;
            }
        }

        return $total_points;
    }

    public function point_color()
    {
        if ($this->total_points() < 20) {
            return 'bg-success';
        } else if ($this->total_points() >= 20 && $this->total_points() < 30) {
            return 'bg-warning';
        } else if ($this->total_points() >= 30) {
            return 'bg-danger';
        }
    }

    public function user_points() {
        return $this->hasMany(UserPoint::class);
    }
}
