<?php

namespace App\Http\Controllers\Manage\User;

use App\Models\User;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\LessonTeacher;
use App\Http\Controllers\Controller;
use App\Models\LastEducation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $this->authorize('read teacher');

        return view('manage.user.teacher.index');
    }

    public function create()
    {
        $this->authorize('create teacher');

        return view('manage.user.teacher.create', [
            'lessons' => Lesson::all(),
            'last_educations' => LastEducation::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create teacher');

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:4|same:re-password',
            're-password' => 'required',
            'last_education' => 'required',
            'entry_date' => 'required|date',
            'status' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'child' => 'required',
            'picture' => 'image|max:1024'
        ];

        if ($request->email) {
            $rules['nip'] = 'unique:users,nip';
            $rules['email'] = 'email|unique:users,email';
        }

        $request->validate($rules);

        $request['no_encrypt'] = $request->password;
        $request['password'] = bcrypt($request->password);
        $request['last_education_id'] = $request->last_education;
        $request['role_id'] = 2;

        if ($request->hasFile('picture')) {
            $request['image'] = $request->file('picture')->store('users', 'public');
        }

        $teacher = User::create($request->all());

        if (session('lesson_teacher')) {
            foreach (session('lesson_teacher') as $lesson_teacher) {
                $teacher->lessons()->attach($lesson_teacher['lesson_id'], ['hours' => $lesson_teacher['hours']]);
            }
            session()->forget('lesson_teacher');
        }

        return redirect(route('app.teacher.index'))->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit(User $teacher)
    {
        $this->authorize('update teacher');

        return view('manage.user.teacher.edit', [
            'teacher' => $teacher,
            'lessons' => Lesson::all(),
            'last_educations' => LastEducation::all()
        ]);
    }

    public function update(User $teacher, Request $request)
    {
        $this->authorize('update teacher');

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $teacher->id,
            'last_education' => 'required',
            'entry_date' => 'required|date',
            'status' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'child' => 'required',
            'picture' => 'image|max:1024'
        ];

        if ($request->email) {
            $rules['nip'] = 'unique:users,nip,' . $teacher->id;
            $rules['email'] = 'email|unique:users,email,' . $teacher->id;
        }

        $request->validate($rules);

        $request['last_education_id'] = $request->last_education;

        if ($request->hasFile('picture')) {
            Storage::disk('public')->delete($teacher->image);
            $request['image'] = $request->file('picture')->store('users', 'public');
        }

        $teacher->update($request->all());

        return redirect(route('app.teacher.index'))->with('success', 'Siswa berhasil diubah');
    }

    public function destroy(User $teacher)
    {
        $this->authorize('delete teacher');

        if ($teacher->image !== NULL) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->lessons()->detach();
        $teacher->delete();

        return redirect(route('app.teacher.index'))->with('success', 'Guru berhasil dihapus');
    }

    public function change_password(User $teacher)
    {
        $this->authorize('change password');

        return view('manage.user.teacher.change_password', [
            'teacher' => $teacher
        ]);
    }

    public function save_password(User $teacher, Request $request)
    {
        $this->authorize('change password');

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:4|same:re_password',
            're_password' => 'required'
        ]);

        if (Hash::check($request->old_password, $teacher->password)) {
            $teacher->password = bcrypt($request->password);
            $teacher->no_encrypt = $request->password;
            $teacher->update();

            return redirect(route('app.teacher.edit', $teacher->id))->with('success', 'Password berhasil diubah');
        } else {
            return back()->with('error', 'Password lama salah');
        }
    }

    public function destroy_image(User $teacher)
    {
        Storage::disk('public')->delete($teacher->image);

        $teacher->image = NULL;
        $teacher->update();

        return back()->with('success', 'Foto berhasil dihapus');
    }

    public function create_lesson(User $teacher, Request $request)
    {
        $request->validate([
            'lesson' => 'required',
            'hours' => 'required'
        ]);

        $exists = LessonTeacher::where('user_id', $teacher->id)->where('lesson_id', $request->lesson)->first();

        if ($exists) {
            return back()->with('error', 'Mata pelajaran sudah ada');
        }

        $teacher->lessons()->attach($request->lesson, ['hours' => $request->hours]);

        return back()->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    public function destroy_lesson(User $teacher, $lesson_id)
    {
        $teacher->lessons()->detach($lesson_id);

        return back()->with('success', 'Mata pelajaran berhasil dihapus');
    }

    public function destroy_all_lesson(User $teacher)
    {
        $teacher->lessons()->detach();

        return back()->with('success', 'Semua mata pelajaran berhasil dihapus');
    }

    public function create_lesson_sess(Request $request)
    {
        $request->validate([
            'lesson' => 'required',
            'hours' => 'required'
        ]);

        $lesson = Lesson::findOrFail($request->lesson);

        $lesson_teacher = session()->get('lesson_teacher');

        if (!$lesson_teacher) {
            $lesson_teacher = [
                $lesson->id => [
                    'lesson_id' => $lesson->id,
                    'lesson_name' => $lesson->name,
                    'hours' => $request->hours
                ]
            ];

            $request->session()->put('lesson_teacher', $lesson_teacher);
            return back()->with('success', 'Mata pelajaran berhasil ditambahkan');
        }

        if (isset($lesson_teacher[$lesson->id])) {
            return back()->with('error', 'Mata pelajaran sudah ada');
        }

        $lesson_teacher[$lesson->id] = [
            'lesson_id' => $lesson->id,
            'lesson_name' => $lesson->name,
            'hours' => $request->hours
        ];

        $request->session()->put('lesson_teacher', $lesson_teacher);
        return back()->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    public function destroy_lesson_sess($lesson_id)
    {
        if ($lesson_id) {
            $lesson_teacher = session()->get('lesson_teacher');

            if (isset($lesson_teacher[$lesson_id])) {
                unset($lesson_teacher[$lesson_id]);
                session()->put('lesson_teacher', $lesson_teacher);
            }
        }

        return back()->with('success', 'Mata pelajaran berhasil dihapus');
    }

    public function destroy_all_lesson_sess()
    {
        session()->forget('lesson_teacher');

        return back()->with('success', 'Semua mata pelajaran berhasil dihapus');
    }
}
