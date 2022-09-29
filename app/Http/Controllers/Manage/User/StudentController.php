<?php

namespace App\Http\Controllers\Manage\User;

use App\Models\User;
use App\Models\Group;
use App\Models\Classroom;
use App\Models\Expertise;
use App\Models\Schoolyear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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

        return redirect(route('app.student.index'))->with('success', 'Siswa berhasil ditambahkan');
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

        if ($request->hasFile('picture')) {
            Storage::disk('public')->delete($student->image);
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

    public function change_password(User $student)
    {
        return view('manage.user.student.change_password', [
            'student' => $student
        ]);
    }

    public function save_password(User $student, Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:4|same:re_password',
            're_password' => 'required'
        ]);

        if (Hash::check($request->old_password, $student->password)) {
            $student->password = bcrypt($request->password);
            $student->no_encrypt = $request->password;
            $student->update();

            return redirect(route('app.student.edit', $student->id))->with('success', 'Password berhasil diubah');
        } else {
            return back()->with('error', 'Password lama salah');
        }
    }

    public function destroy_image(User $student)
    {
        Storage::disk('public')->delete($student->image);

        $student->image = NULL;
        $student->update();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
