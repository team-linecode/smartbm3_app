<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->orderBy('name');
    }

    public function check_default_permission($permission)
    {
        if ($this->name == 'developer' && $permission == 'developer access') {
            return true;
        } elseif ($this->name == 'teacher' && $permission == 'teacher access') {
            return true;
        } elseif ($this->name == 'student' && $permission == 'student access') {
            return true;
        } elseif ($this->name == 'finance' && $permission == 'finance access') {
            return true;
        } elseif ($this->name == 'staff' && $permission == 'staff access') {
            return true;
        } else {
            return false;
        }
    }

    public function default_permission_id()
    {
        if ($this->name == 'developer') {
            return $this->permissions()->where('name', 'developer access')->first()->id;
        } elseif ($this->name == 'teacher') {
            return $this->permissions()->where('name', 'teacher access')->first()->id;
        } elseif ($this->name == 'student') {
            return $this->permissions()->where('name', 'student access')->first()->id;
        } elseif ($this->name == 'finance') {
            return $this->permissions()->where('name', 'finance access')->first()->id;
        } elseif ($this->name == 'staff') {
            return $this->permissions()->where('name', 'staff access')->first()->id;
        } else {
            return false;
        }
    }
}
