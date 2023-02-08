<?php

namespace App\Http\Controllers\Manage\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Position;
use App\Models\Classroom;
use App\Models\Expertise;
use Illuminate\Http\Request;
use App\Models\LastEducation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index()
    {
        $this->authorize('read staff');

        return view('manage.user.staff.index');
    }

    public function create()
    {
        $this->authorize('create staff');

        return view('manage.user.staff.create', [
            'roles' => Role::whereIn('name', ['staff', 'finance', 'FI'])->get(),
            'last_educations' => LastEducation::all(),
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create staff');

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:4|same:re-password',
            're-password' => 'required',
            'roles' => 'required|array',
            'last_educations' => 'required|array',
            'last_education' => 'required',
            'entry_date' => 'required|date',
            'status' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'child' => 'required',
            'picture' => 'image|max:1024'
        ];

        if ($request->nip) {
        if ($request->nip) {
            $rules['nip'] = 'unique:users,nip';
        }

        if ($request->email) {
        }

        if ($request->email) {
            $rules['email'] = 'email|unique:users,email';
        }

        if ($request->is_hometeacher == 1) {
            $rules['classroom'] = 'required';
            $rules['expertise'] = 'required';

            // check walas dari database
            $check_hometeacher = User::where('is_hometeacher', '1')->where('classroom_id', $request->classroom)->where('expertise_id', $request->expertise)->first();
            if ($check_hometeacher) {
                return back()->with('error', $check_hometeacher->name . ' sudah menjadi wali kelas ' . $check_hometeacher->myClass());
            }

            $request['is_hometeacher'] = '1';
            $request['classroom_id'] = $request->classroom;
            $request['expertise_id'] = $request->expertise;
        }

        $request->validate($rules);

        $request['no_encrypt'] = $request->password;
        $request['password'] = bcrypt($request->password);
        $request['role_id'] = 4;
        $request['last_education_id'] = $request->last_education;
        $request['role_id'] = 4;
        $request['last_education_id'] = $request->last_education;

        if ($request->hasFile('picture')) {
            $request['image'] = $request->file('picture')->store('users', 'public');
        }

        $user = User::create($request->all());
        $user->assignRole($request->roles);
        // set positions
        $position = Position::where('slug', 'wali-kelas')->first();
        if ($position) {
            $user->positions()->attach($position->id);
        } else {
            return back()->with('error', 'System error: Model Position 404');
        }

        return redirect(route('app.staff.index'))->with('success', 'Staff berhasil ditambahkan');
    }

    public function edit(User $staff)
    {
        $this->authorize('update staff');

        return view('manage.user.staff.edit', [
            'staff' => $staff,
            'roles' => Role::whereIn('name', ['staff', 'finance', 'FI'])->get(),
            'last_educations' => LastEducation::all(),
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::all()
        ]);
    }

    public function update(User $staff, Request $request)
    {
        $this->authorize('update staff');

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $staff->id,
            'roles' => 'required|array',
            'roles' => 'required|array',
            'entry_date' => 'required|date',
            'status' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'child' => 'required',
            'picture' => 'image|max:1024'
        ];

        if ($request->nip) {
            $rules['nip'] = 'unique:users,nip,' . $staff->id;
        }
        if ($request->email) {
            $rules['email'] = 'email|unique:users,email,' . $staff->id;
        }

        if ($request->is_hometeacher == 1) {
            $rules['classroom'] = 'required';
            $rules['expertise'] = 'required';

            // check walas dari database
            $check_hometeacher = User::where('id', '!=', $staff->id)->where('is_hometeacher', '1')->where('classroom_id', $request->classroom)->where('expertise_id', $request->expertise)->first();
            if ($check_hometeacher) {
                return back()->with('error', $check_hometeacher->name . ' sudah menjadi wali kelas ' . $check_hometeacher->myClass());
            }

            $request['is_hometeacher'] = '1';
            $request['classroom_id'] = $request->classroom;
            $request['expertise_id'] = $request->expertise;
        } else {
            $request['is_hometeacher'] = '0';
            $request['classroom_id'] = NULL;
            $request['expertise_id'] = NULL;
        }

        $request->validate($rules);

        $request['role_id'] = 4;
        $request['role_id'] = 4;
        $request['last_education_id'] = $request->last_education ?? NULL;

        if ($request->hasFile('picture')) {
            Storage::disk('public')->delete($staff->image);
            $request['image'] = $request->file('picture')->store('users', 'public');
        }

        $staff->syncRoles($request->roles);
        $staff->syncRoles($request->roles);
        $staff->update($request->all());

        // sync positions
        $position = Position::where('slug', 'wali-kelas')->first();
        if ($position) {
            if ($request->is_hometeacher == 1) {
                $staff->positions()->attach($position->id);
            } else if ($request->is_hometeacher == 0) {
                $staff->positions()->detach($position->id);
            }
        } else {
            return back()->with('error', 'System error: Model Position 404');
        }

        return redirect(route('app.staff.index'))->with('success', 'Staff berhasil diubah');
    }

    public function destroy(User $staff)
    {
        $this->authorize('delete staff');

        if ($staff->image !== NULL) {
            Storage::disk('public')->delete($staff->image);
        }

        $staff->positions()->detach();

        $staff->delete();

        return redirect(route('app.staff.index'))->with('success', 'Staff berhasil dihapus');
    }

    public function change_password(User $staff)
    {
        $this->authorize('change password');

        return view('manage.user.staff.change_password', [
            'staff' => $staff
        ]);
    }

    public function save_password(User $staff, Request $request)
    {
        $this->authorize('change password');

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:4|same:re_password',
            're_password' => 'required'
        ]);

        if (Hash::check($request->old_password, $staff->password)) {
            $staff->password = bcrypt($request->password);
            $staff->no_encrypt = $request->password;
            $staff->update();

            return redirect(route('app.staff.edit', $staff->id))->with('success', 'Password berhasil diubah');
        } else {
            return back()->with('error', 'Password lama salah');
        }
    }

    public function destroy_image(User $staff)
    {
        Storage::disk('public')->delete($staff->image);

        $staff->image = NULL;
        $staff->update();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
