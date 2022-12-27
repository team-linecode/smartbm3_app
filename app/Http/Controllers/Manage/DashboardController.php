<?php

namespace App\Http\Controllers\Manage;

use DateTime;
use App\Models\UserPoint;
use App\Models\PenaltyPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            $charts = [];
            if (request()->get('penalty') || request()->get('from_date') || request()->get('to_date')) {
                $penalty_id = request()->get('penalty');
                $from_date = request()->get('from_date');
                $to_date = request()->get('to_date');

                $from = new DateTime($from_date);
                $to   = new DateTime($to_date);

                for ($i = $from; $i <= $to; $i->modify('+1 day')) {
                    $charts["label"] = $i->format("d M");
                }
            }
            dd($charts);

            return view('manage.dashboard.dashboard-gac', [
                'penalty_points' => PenaltyPoint::all(),
                'charts' => $charts
            ]);
        } else {
            return view('manage.dashboard.index');
        }
    }
}
