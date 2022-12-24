<?php

namespace App\Http\Controllers\Manage\Point;

use App\Exports\UserPointExport;
use App\Exports\UserTotalPointExport;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Expertise;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportPointController extends Controller
{
    public function index()
    {
        return view('manage.point.report_point.index', [
            'classrooms' => Classroom::orderBy('name')->get(),
            'expertises' => Expertise::orderBy('name')->get()
        ]);
    }

    public function export_point(Request $request)
    {
        $userpointexport = new UserPointExport($request->from_date, $request->to_date, $request->type);
        return Excel::download($userpointexport, 'users.xlsx');
    }

    public function export_total_point(Request $request)
    {
        $userpointexport = new UserTotalPointExport($request->classrooms, $request->expertises, $request->from_date, $request->to_date);
        return Excel::download($userpointexport, 'users.xlsx');
    }
}
