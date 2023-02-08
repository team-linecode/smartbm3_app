<?php

namespace App\Http\Controllers\Manage\Picket;

use App\Models\Day;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TeacherAbsent;
use App\Http\Controllers\Controller;

class TeacherAbsentController extends Controller
{
    public function index()
    {
        $this->authorize('read teacher absent');

        return view('manage.picket.teacher_absent.index', [
            'teacher_absents' => TeacherAbsent::latest()->get()
        ]);
    }

    public function create()
    {
        $this->authorize('create teacher absent');

        return view('manage.picket.teacher_absent.create', [
            'users' => User::role(['teacher'])->orderByDesc('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create teacher absent');

        $request->validate([
            'user' => 'required',
            'status' => 'required',
            'description' => 'max:255',
        ]);

        $teacher_absent = TeacherAbsent::where('user_id', $request->user)->whereDate('created_at', date('Y-m-d'))->first();
        if ($teacher_absent) {
            return back()->with('error', 'Guru sudah di absen');
        }

        $request['user_id'] = $request->user;

        TeacherAbsent::create($request->all());

        if ($request->stay) {
            $route = 'app.teacher_absent.create';
        } else {
            $route = 'app.teacher_absent.index';
        }

        return redirect()->route($route)->with('success', 'Absen berhasil ditambahkan');
    }

    public function edit(TeacherAbsent $teacher_absent)
    {
        $this->authorize('update teacher absent');

        return view('manage.picket.teacher_absent.edit', [
            'teacher_absent' => $teacher_absent,
            'users' => User::role(['teacher', 'staff'])->orderByDesc('name')->get(),
        ]);
    }

    public function update(TeacherAbsent $teacher_absent, Request $request)
    {
        $this->authorize('create teacher absent');

        $request->validate([
            'user' => 'required',
            'status' => 'required',
            'description' => 'max:255',
        ]);

        $request['user_id'] = $request->user;

        $teacher_absent->update($request->all());

        return redirect()->route('app.teacher_absent.index')->with('success', 'Absen berhasil diubah');
    }

    public function destroy(TeacherAbsent $teacher_absent)
    {
        $this->authorize('delete teacher absent');

        $teacher_absent->delete();

        return redirect(route('app.teacher_absent.index'))->with('success', 'Absen berhasil dihapus');
    }
}
