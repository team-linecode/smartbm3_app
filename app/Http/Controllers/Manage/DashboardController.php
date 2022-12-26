<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\UserPoint;
use Illuminate\Http\Request;

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
        } else {
            return view('manage.dashboard.index');
        }
    }
}
