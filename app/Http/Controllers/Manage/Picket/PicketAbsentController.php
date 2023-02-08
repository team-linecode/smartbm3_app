<?php

namespace App\Http\Controllers\Manage\Picket;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Expertise;
use App\Models\StudentAttend;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class PicketAbsentController extends Controller
{
    public function index()
    {
        if (request()->get('classroom') && request()->get('expertise')) {
            $users = User::role('student')->whereHas('schoolyear', function($query) {
                $query->where('graduated', '0');
            })->where('classroom_id', request()->get('classroom'))
              ->where('expertise_id', request()->get('expertise'))
              ->orderBy('classroom_id')
              ->orderBy('expertise_id')
              ->get();
        } else {
            $users = [];
        }

        return view('manage.picket.absent.create', [
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::orderBy('name')->get(),
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $attend = StudentAttend::where('user_id', $request->user_id)->whereDate('created_at', date('Y-m-d'))->first();

        if (!$attend) {
            StudentAttend::create($request->all());

            $type = 'create';
        } else {
            if ($attend->status != $request->status) {
                $attend->status = $request->status;
                $attend->update();
                $type = 'change';
            } else {
                $attend->delete();
                $type = 'delete';
            }

        }

        return response()->json([
            'code' => 200,
            'type' => $type,
            'user_id' => $request->user_id,
            'status' => $request->status
        ]);
    }
}
