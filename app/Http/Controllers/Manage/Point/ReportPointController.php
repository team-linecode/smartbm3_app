<?php

namespace App\Http\Controllers\Manage\Point;

use App\Exports\UserPointExport;
use App\Exports\UserTotalPointExport;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Expertise;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'type' => 'required'
        ]);

        $userpointexport = new UserPointExport($request->from_date, $request->to_date, $request->type);

        if ($request->export_as == 'excel') {
            return Excel::download($userpointexport, 'users.xlsx');
        } else if ($request->export_as == 'pdf') {
            $data["from_date"] = $request->from_date;
            $data["to_date"] = $request->to_date;
            $data["user_points"] = $userpointexport->collection()->toArray();
            unset($data["user_points"][0]);

            view()->share('data', $data);
            return PDF::loadView('manage.point.report_point.export_pdf', $data)->setPaper('F4')->stream('users.pdf');
        } else {
            abort(404);
        }
    }

    public function export_total_point(Request $request)
    {
        $request->validate([
            'classrooms' => 'required|array',
            'expertises' => 'required|array',
            'from_date2' => 'required|date',
            'to_date2' => 'required|date'
        ]);

        $userpointexport = new UserTotalPointExport($request->classrooms, $request->expertises, $request->from_date2, $request->to_date2);
        return Excel::download($userpointexport, 'users.xlsx');
    }
}
