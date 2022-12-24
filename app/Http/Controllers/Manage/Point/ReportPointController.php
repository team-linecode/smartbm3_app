<?php

namespace App\Http\Controllers\Manage\Point;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportPointController extends Controller
{
    public function index()
    {
        return view('manage.point.report_point.index');
    }

    public function store()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
