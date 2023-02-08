<?php

namespace App\Http\Controllers\Manage\Picket;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentApprenticeship;
use Carbon\Carbon;

class StudentApprenticeshipController extends Controller
{
    public function index()
    {
        $this->authorize('read student apprenticeship');

        return view('manage.picket.student_apprenticeship.index', [
            'student_apprenticeships' => StudentApprenticeship::whereHas('user', function ($query) {
                $query->orderBy('name')->orderBy('classroom_id')->orderBy('expertise_id');
            })->orderBy('start_date')->get()
        ]);
    }

    public function create()
    {
        $this->authorize('create student apprenticeship');

        return view('manage.picket.student_apprenticeship.create', [
            'users' => User::role('student')->whereHas('schoolyear', function ($query) {
                $query->where('graduated', '0');
            })->whereIn('classroom_id', [2, 3])->orderBy('classroom_id')->orderBy('expertise_id')->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create student apprenticeship');

        $request->validate([
            'users' => 'required|array|unique:student_apprenticeships,user_id',
        ]);

        $student_apprenticeship = [];

        foreach ($request->users as $index => $user) {
            $student_apprenticeship[$index]['user_id'] = $user;
            $student_apprenticeship[$index]['start_date'] = $request->start_date;
            $student_apprenticeship[$index]['end_date'] = $request->end_date;
            $student_apprenticeship[$index]['created_at'] = Carbon::now()->format('Y-m-d');
            $student_apprenticeship[$index]['updated_at'] = Carbon::now()->format('Y-m-d');
        }

        StudentApprenticeship::insert($student_apprenticeship);

        if ($request->stay) {
            $route = 'app.student_apprenticeship.create';
        } else {
            $route = 'app.student_apprenticeship.index';
        }

        return redirect()->route($route)->with('success', 'Siswa PKL berhasil ditambahkan');
    }

    public function edit(StudentApprenticeship $student_apprenticeship)
    {
        $this->authorize('update student apprenticeship');

        return view('manage.picket.student_apprenticeship.edit', [
            'student_apprenticeship' => $student_apprenticeship,
            'users' => User::role('student')->whereHas('schoolyear', function ($query) {
                $query->where('graduated', '0');
            })->whereIn('classroom_id', [2, 3])->orderBy('classroom_id')->orderBy('expertise_id')->get()
        ]);
    }

    public function update(StudentApprenticeship $student_apprenticeship, Request $request)
    {
        $this->authorize('create student apprenticeship');

        $request->validate([
            'user' => 'required|unique:student_apprenticeships,user_id,' . $student_apprenticeship->id,
        ]);

        $request['user_id'] = $request->user;
        $student_apprenticeship->update($request->all());

        return redirect()->route('app.student_apprenticeship.index')->with('success', 'Siswa PKL berhasil diubah');
    }

    public function destroy(StudentApprenticeship $student_apprenticeship)
    {
        $this->authorize('delete student apprenticeship');

        $student_apprenticeship->delete();

        return redirect(route('app.student_apprenticeship.index'))->with('success', 'Siswa PKL berhasil dihapus');
    }
}
