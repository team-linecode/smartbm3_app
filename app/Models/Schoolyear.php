<?php

namespace App\Models;

use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schoolyear extends Model
{
    use HasFactory;

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    public function getYears($index = 'none')
    {
        $year = explode('/', $this->name);

        $begin = new DateTime($year[0] . '-07-01');
        $end = new DateTime($year[1] + 1 . '-07-01');

        $interval = DateInterval::createFromDateString('1 years');
        $period = new DatePeriod($begin, $interval, $end);

        $years = [];
        foreach ($period as $dt) {
            $years[] = $dt->format("Y");
        }

        if ($index !== 'none') {
            return $years[$index];
        } else {
            return $years;
        }
    }
}
