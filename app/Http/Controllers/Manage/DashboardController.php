<?php

namespace App\Http\Controllers\Manage;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserPoint;
use App\Models\PenaltyPoint;
use App\Http\Controllers\Controller;
use App\Models\PenaltyCategory;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasPermissionTo('dashboard student')) {
            $point = auth()->user()->total_points();
            return view('manage.dashboard.dashboard-student', [
                'point' => $point,
                'user_points' => UserPoint::where('user_id', auth()->user()->id)->latest()->get()
            ]);
        } else if (auth()->user()->hasPermissionTo('dashboard gac')) {
            $chart = [];

            // mengambil data dari url (method: get)
            $penalty_id = request()->get('penalty') ?? 'all';
            $from_date = request()->get('from_date') ?? date('Y-m-') . '01';
            $to_date = request()->get('to_date') ?? date_format(date_add(Carbon::now(), date_interval_create_from_date_string(cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) - date('d') . " days")), "Y-m-d");

            // konversi tanggal menggunakan DateTime()
            $from = new DateTime($from_date);
            $to   = new DateTime($to_date);

            // membuat query pengambilan data penalty_points
            $penalty_points = PenaltyPoint::where('id', $penalty_id == 'all' ? '!=' : '=', $penalty_id)->whereHas('user_points', function ($query) use ($from, $to) {
                $query->whereBetween('date', [$from->format("Y-m-d") . ' 00:00:00', $to->format("Y-m-d") . ' 23:59:59']);
            })->get();

            // membuat variabel untuk menampung data chart yang akan ditampilkan di dashboard
            $datas = [];
            for ($i = $from; $i <= $to; $i->modify('+1 day')) {
                $chart["labels"][] = '"' . $i->format("d M") . '"';

                // membuat variabel untuk menampung total user_point
                $user_point_count = 0;
                foreach ($penalty_points as $pp) {
                    foreach ($pp->user_points as $up) {
                        // jika tanggal pada user_point sama dengan tanggal yang di looping
                        if (date('Y-m-d', strtotime($up->date)) == $i->format("Y-m-d")) {
                            // maka variabel user_point_count ditambah 1
                            $user_point_count += 1;
                        }
                    }
                }

                // array datas akan diisi sebanyak sejumlah selisih tanggal
                // misalkan selisih tanggal dari 01 jan 2022 ke 31 jan 2022 adalah (31)
                // maka datas akan diisi sebanyak 31 kali
                $datas[] = $user_point_count;
            }

            $chart['labels'] = implode(',', $chart['labels']);
            $chart['datas']   = implode(',', $datas);

            return view('manage.dashboard.dashboard-gac', [
                'top_students' => User::withCount('user_points')->whereHas('user_points', function ($query) {
                    $query->where('type', 'plus');
                })->orderByDesc('user_points_count')->take(5)->get(),
                'penalty_categories' => PenaltyCategory::all(),
                'penalty_points' => PenaltyPoint::all(),
                'chart' => $chart
            ]);
        } else {
            return view('manage.dashboard.index');
        }
    }
}
