<?php

namespace App\Http\Controllers\Manage\Picket;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Expertise;
use App\Models\PicketSchedule;
use App\Models\StudentApprenticeship;
use Illuminate\Http\Request;
use App\Models\StudentAttend;
use App\Models\TeacherAbsent;
use App\Models\UserPoint;
use App\Models\User;
use PDF;
use DateInterval;
use DatePeriod;
use DateTime;

class PicketReportController extends Controller
{
    public function index()
    {
        return view('manage.picket.report.index', [
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);
        
        $picket_schedule = PicketSchedule::where('day_id', date('N', strtotime($request->date)))->first();
        
        if (!$picket_schedule) {
            return back()->with('error', 'Tidak ada jadwal piket hari ini');
        }

        $data['students'] = StudentAttend::whereDate('created_at', $request->date)->get();
        $data['student_apprenticeships'] = StudentApprenticeship::all();
        $data['latest'] = UserPoint::whereDate('date', $request->date)->whereHas('penalty', function($query) {
            $query->where('code', 'C.1');
        })->get();
        $data['classrooms'] = Classroom::orderBy('name')->get();
        $data['expertises'] = Expertise::orderBy('name')->get();
        $data['picket_schedule'] = $picket_schedule;
        $data['teacher_absents'] = TeacherAbsent::whereDate('created_at', $request->date)->get();
        $data['date'] = $request->date;

        return PDF::loadView('manage.picket.report.daily_report', ['data' => $data])->setPaper('F4')->stream('Laporan Ketidakhadiran _ ' . dayID(date('N', strtotime($request->date))) . ', ' . date('d') . ' ' . monthID(date('n', strtotime($request->date))) . ' ' . date('Y', strtotime($request->date)) . '.pdf');
    }
    
    public function export_monthly(Request $request)
    {
        $date = $request->date;
        $classroom = Classroom::findOrFail($request->classroom);
        $expertises = Expertise::orderBy('name')->get();
        
        $students = User::where('classroom_id', $classroom->id)->whereHas('schoolyear', function($query) {
            $query->where('graduated', '0');
        })->orderBy('name')->get();
        
        return PDF::loadView('manage.picket.report.monthly_report', [
            'date' => $date,
            'classroom' => $classroom,
            'expertises' => $expertises,
            'total_day' => cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date))),
            'students' => $students
        ])->setPaper('F4', 'landscape')->stream('Laporan Piket Bulanan _ ' . monthID(date('n', strtotime($request->date))) . ' ' . date('Y', strtotime($request->date)) . '.pdf');
    }
    
    public function export_custom(Request $request)
    {
        $date1 = $request->from_date;
        $date2 = $request->to_date;
        $classroom = Classroom::findOrFail($request->classroom);
        $expertises = Expertise::orderBy('name')->get();
        // period
        $start_date = new DateTime($date1);
        $end_date   = new DateTime($date2);
        $end_date->modify('+1 day');
        
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start_date, $interval, $end_date);
        
        $students = User::where('classroom_id', $classroom->id)->whereHas('schoolyear', function($query) {
            $query->where('graduated', '0');
        })->orderBy('name')->get();
        
        $end_date->modify('-1 day');
        return PDF::loadView('manage.picket.report.custom_report', [
            'date1' => $date1,
            'date2' => $date2,
            'period' => $period,
            'classroom' => $classroom,
            'expertises' => $expertises,
            'total_day' => $start_date->diff($end_date)->d + 1,
            'students' => $students
        ])->setPaper('F4', 'landscape')->stream('Laporan Piket _ ' . date('d M Y', strtotime($date1)) . ' - ' . date('d M Y', strtotime($date2)) . '.pdf');
    }
}
