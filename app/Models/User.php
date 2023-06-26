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
        'is_hometeacher',
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

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'student_id');
    }

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

    public function schoolyearsForSPP($type, $classroom)
    {
        $schoolyears = [];
        $types = [];

        foreach (range(explode('-', auth()->user()->schoolyear->slug)[0], explode('-', auth()->user()->schoolyear->slug)[1]) as $schoolyear) {
            $schoolyears[] = $schoolyear;
        }

        if ($classroom == '10') {
            $types['a'] = $schoolyears[0];
            $types['b'] = $schoolyears[1];
        } else if ($classroom == '11') {
            $types['a'] = $schoolyears[1];
            $types['b'] = $schoolyears[2];
        } else if ($classroom == '12') {
            $types['a'] = $schoolyears[2];
            $types['b'] = $schoolyears[3];
        }

        return $types[$type];
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
            : 'Alumni');
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

    public function user_points()
    {
        return $this->hasMany(UserPoint::class);
    }

    public function student_attends()
    {
        return $this->hasMany(StudentAttend::class);
    }

    public function isHomeTeacher()
    {
        if ($this->is_hometeacher == 1) {
            return true;
        }

        return false;
    }

    public function absentToday($button_type = null)
    {
        $attend = StudentAttend::where('user_id', $this->id)->whereDate('created_at', date('Y-m-d'))->first();

        $button = '';

        if (!$attend) {
            if ($button_type != null) {
                if ($button_type == 's') {
                    $button = 'btn-outline-primary';
                } else if ($button_type == 'i') {
                    $button = 'btn-outline-warning';
                } else if ($button_type == 'a') {
                    $button = 'btn-outline-danger';
                }
            }

            return [
                'check' => false,
                'button' => $button,
            ];
        } else {
            if ($button_type != null) {
                if ($attend->status == 's') {
                    if ($button_type == 's') {
                        $button = 'btn-primary';
                    } else if ($button_type == 'i') {
                        $button = 'btn-outline-warning';
                    } else if ($button_type == 'a') {
                        $button = 'btn-outline-danger';
                    }
                } else if ($attend->status == 'i') {
                    if ($button_type == 's') {
                        $button = 'btn-outline-primary';
                    } else if ($button_type == 'i') {
                        $button = 'btn-warning';
                    } else if ($button_type == 'a') {
                        $button = 'btn-outline-danger';
                    }
                } else if ($attend->status == 'a') {
                    if ($button_type == 's') {
                        $button = 'btn-outline-primary';
                    } else if ($button_type == 'i') {
                        $button = 'btn-outline-warning';
                    } else if ($button_type == 'a') {
                        $button = 'btn-danger';
                    }
                }
            }

            return [
                'check' => true,
                'button' => $button,
            ];
        }
    }

    public function apprenticeship()
    {
        return $this->hasOne(StudentApprenticeship::class);
    }

    public function isApprenticeship()
    {
        if ($this->apprenticeship()->exists()) {
            $end_date = strtotime($this->apprenticeship->end_date);
            $date_now = time();

            if ($this->apprenticeship->end_date != NULL) {
                if ($end_date > $date_now) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }

            return true;
        } else {
            return false;
        }
    }

    public function checkAbsentStatus($date)
    {
        $date = date('Y-m-d', strtotime($date));

        $student_attend = StudentAttend::where('user_id', $this->id)->whereDate('created_at', $date)->first();

        if ($student_attend) {
            return $student_attend->status;
        } else {
            return '';
        }
    }

    public function checkAbsentStatusColor($date)
    {
        $date = date('Y-m-d', strtotime($date));

        $student_attend = StudentAttend::where('user_id', $this->id)->whereDate('created_at', $date)->first();

        if ($student_attend) {
            if ($student_attend->status == 's') {
                return 'lightskyblue';
            } else if ($student_attend->status == 'i') {
                return 'yellow';
            } else {
                return 'red';
            }
        } else {
            return 'transparent';
        }
    }

    public function getTotalAbsentByStatus($status, $date)
    {
        return StudentAttend::where('user_id', $this->id)->where('status', $status)->whereMonth('created_at', date('m-Y', strtotime($date)))->count();
    }

    public function getTotalAbsent($date)
    {
        return StudentAttend::where('user_id', $this->id)->whereMonth('created_at', date('m-Y', strtotime($date)))->count();
    }
}
