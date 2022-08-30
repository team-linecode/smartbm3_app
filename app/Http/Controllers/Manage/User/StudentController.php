<?php

namespace App\Http\Controllers\Manage\User;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Expertise;
use App\Models\Group;
use App\Models\Schoolyear;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $this->authorize('developer access');

        return view('manage.user.student.index');
    }

    public function create()
    {
        $this->authorize('developer access');

        return view('manage.user.student.create', [
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::all(),
            'schoolyears' => Schoolyear::all(),
            'groups' => Group::all()
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:4|same:re-password',
            're-password' => 'required',
            'classroom' => 'required',
            'expertise' => 'required',
            'schoolyear' => 'required',
            'group' => 'required',
            'status' => 'required',
            'picture' => 'image|max:1024'
        ];

        if ($request->email) {
            $rules['nisn'] = 'unique:users,nisn';
            $rules['email'] = 'email|unique:users,email';
        }

        $request->validate($rules);

        $request['no_encrypt'] = $request->password;
        $request['password'] = bcrypt($request->password);
        $request['group_id'] = $request->group;
        $request['schoolyear_id'] = $request->schoolyear;
        $request['role_id'] = 3;
        $request['classroom_id'] = $request->classroom;
        $request['expertise_id'] = $request->expertise;
        $request['alumni'] = $request->status;

        if ($request->hasFile('picture')) {
            $request['image'] = $request->file('picture')->store('users', 'public');
        }

        User::create($request->all());

        return redirect(route('app.student.index'))->with('success', 'Siswa berhasil disimpan');
    }

    public function edit(User $student)
    {
        $this->authorize('developer access');

        return view('manage.user.student.edit', [
            'student' => $student,
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::all(),
            'schoolyears' => Schoolyear::all(),
            'groups' => Group::all()
        ]);
    }

    public function update(User $student, Request $request)
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $student->id,
            'classroom' => 'required',
            'expertise' => 'required',
            'schoolyear' => 'required',
            'group' => 'required',
            'status' => 'required',
            'picture' => 'image|max:1024'
        ];

        if ($request->email) {
            $rules['nisn'] = 'unique:users,nisn,' . $student->id;
            $rules['email'] = 'email|unique:users,email,' . $student->id;
        }

        $request->validate($rules);

        if ($student->image != NULL) {
            Storage::disk('public')->delete($student->image);
        }

        if ($request->hasFile('picture')) {
            $request['image'] = $request->file('picture')->store('users', 'public');
        }

        $request['group_id'] = $request->group;
        $request['schoolyear_id'] = $request->schoolyear;
        $request['classroom_id'] = $request->classroom;
        $request['expertise_id'] = $request->expertise;
        $request['alumni'] = $request->status;

        $student->update($request->all());

        return redirect(route('app.student.index'))->with('success', 'Siswa berhasil diubah');
    }

    public function destroy(User $student)
    {
        if ($student->image !== NULL) {
            Storage::disk('public')->delete($student->image);
        }

        $student->delete();

        return redirect(route('app.student.index'))->with('success', 'Siswa berhasil dihapus');
    }

    public function destroy_image(User $student)
    {
        if ($student->image != NULL) {
            $student->image = NULL;
            $student->update();

            Storage::disk('public')->delete($student->image);
        }

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
