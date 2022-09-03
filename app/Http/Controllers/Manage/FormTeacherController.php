<?php

namespace App\Http\Controllers\Manage;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Expertise;
use App\Models\FormTeacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormTeacherController extends Controller
{
    public function index()
    {
        return view('manage.form_teacher.index', [
            'form_teachers' => FormTeacher::orderBy('classroom_id')->orderBy('expertise_id')->get()
        ]);
    }

    public function create()
    {
        return view('manage.form_teacher.create', [
            'teachers' => User::whereHas('role', function ($q) {
                $q->where('name', 'teacher');
            })->get(),
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher' => 'required',
            'classroom' => 'required',
            'expertise' => 'required'
        ]);

        $hasFormTeacher = FormTeacher::where('classroom_id', $request->classroom)
            ->where('expertise_id', $request->expertise)
            ->first();

        if ($hasFormTeacher) {
            return back()->with('error', $hasFormTeacher->user->name . ' adalah wali kelas ' . $hasFormTeacher->classroom->name . ' ' . $hasFormTeacher->expertise->name);
        }

        $request['user_id'] = $request->teacher;
        $request['classroom_id'] = $request->classroom;
        $request['expertise_id'] = $request->expertise;

        $form_teacher = FormTeacher::create($request->all());

        return redirect(route('app.form_teacher.index'))->with('success', $form_teacher->user->name . ' menjadi wali kelas ' . $form_teacher->classroom->name . ' ' . $form_teacher->expertise->name);
    }

    public function edit(FormTeacher $form_teacher)
    {
        return view('manage.form_teacher.edit', [
            'form_teacher' => $form_teacher,
            'teachers' => User::whereHas('role', function ($q) {
                $q->where('name', 'teacher');
            })->get(),
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::all()
        ]);
    }

    public function update(FormTeacher $form_teacher, Request $request)
    {
        $request->validate([
            'classroom' => 'required',
            'expertise' => 'required'
        ]);

        $hasFormTeacher = FormTeacher::where('classroom_id', $request->classroom)
            ->where('expertise_id', $request->expertise)
            ->first();

        if ($hasFormTeacher && $hasFormTeacher->user_id != $form_teacher->user_id) {
            return back()->with('error', $hasFormTeacher->user->name . ' adalah wali kelas ' . $hasFormTeacher->classroom->name . ' ' . $hasFormTeacher->expertise->name);
        }

        $request['classroom_id'] = $request->classroom;
        $request['expertise_id'] = $request->expertise;

        $form_teacher->update($request->all());

        return redirect(route('app.form_teacher.index'))->with('success', 'Wali kelas berhasil diubah');
    }

    public function destroy(FormTeacher $form_teacher)
    {
        $form_teacher->delete();
        return redirect(route('app.form_teacher.index'))->with('success', 'Wali kelas telah dihapus');
    }
}
