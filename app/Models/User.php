<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'group_id',
        'schoolyear_id',
        'alumni',
        'role_id',
        'classroom_id',
        'expertise_id',
        'verify_token',
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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {
        return $this->role->permissions()->where('name', $permission)->first() ?: false;
    }

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
}
