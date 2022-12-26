<?php

namespace App\Exports;

use App\Models\UserPoint;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserPointExport implements FromCollection
{
    private $from_date, $to_date, $type;

    public function __construct($from_date, $to_date, $type)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->type = $type;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $type = [];
        if ($this->type == 'all') {
            $type[] = "plus";
            $type[] = "minus";
        } else if ($this->type == 'plus') {
            $type[] = "plus";
        } else if ($this->type == 'minus') {
            $type[] = "minus";
        }

        $user_points = UserPoint::whereBetween('date', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])->whereIn('type', $type)->whereHas('user', function ($user) {
            $user->orderBy('classroom_id')->orderBy('expertise_id');
        })->orderBy('date')->get();

        $objects = [
            [
                'no' => 'NO',
                'name' => 'NAMA',
                'classroom' => 'KELAS',
                'description' => 'KETERANGAN',
                'type' => 'TIPE',
                'point' => 'POIN',
                'date' => 'TANGGAL'
            ]
        ];

        foreach ($user_points as $i => $user_point) {
            $objects[($i + 1)]["no"] = ($i + 1);
            $objects[($i + 1)]["name"] = $user_point->user->name;
            $objects[($i + 1)]["classroom"] = $user_point->user->myClass();
            $objects[($i + 1)]["description"] = $user_point->description ?? $user_point->penalty->name;
            $objects[($i + 1)]["type"] = $user_point->type;
            $objects[($i + 1)]["point"] = $user_point->point ?? $user_point->penalty->point;
            $objects[($i + 1)]["date"] = date('d-m-Y H:i:s', $user_point->date());
        }

        return collect((object) $objects);
    }
}
