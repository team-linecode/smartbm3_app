<?php

namespace App\Exports;

use App\Models\User;
use App\Models\UserPoint;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserTotalPointExport implements FromCollection
{
    private $from_date, $to_date, $type;

    public function __construct(array $classrooms, array $expertises, string $from_date, string $to_date)
    {
        $this->classrooms = $classrooms;
        $this->expertises = $expertises;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $classroom_ids = $this->classrooms;
        $expertise_ids = $this->expertises;

        $users = User::whereHas('schoolyear', function($query) {
            $query->where('graduated', '0');
        })->whereIn('classroom_id', $classroom_ids)->whereIn('expertise_id', $expertise_ids)->orderBy('classroom_id')->orderBy('expertise_id')->orderBy('name')->get();

        $objects = [
            [
                'no' => 'NO',
                'name' => 'NAMA',
                'classroom' => 'KELAS',
                'point' => 'TOTAL POIN',
            ]
        ];

        foreach ($users as $i => $user) {
            $objects[($i + 1)]["no"] = ($i + 1);
            $objects[($i + 1)]["name"] = $user->name;
            $objects[($i + 1)]["classroom"] = $user->myClass();
            $objects[($i + 1)]["point"] = (int) $user->total_points($this->from_date, $this->to_date);
        }

        return collect((object) $objects);
    }
}
