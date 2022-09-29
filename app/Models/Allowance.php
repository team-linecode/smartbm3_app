<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function details()
    {
        return $this->hasMany(AllowanceDetail::class);
    }
}
