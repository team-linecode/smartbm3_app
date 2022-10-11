<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $fillable = ['month', 'status'];

    public function details()
    {
        return $this->hasMany(SalaryDetail::class);
    }
}
