<?php

namespace App\Http\Controllers\Manage\User;

use App\Models\Role;
use App\Models\User;
use App\Models\LastEducation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function GuzzleHttp\Promise\all;

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
            'roles' => Role::whereIn('name', ['staff', 'finance'])->get(),
            'last_educations' => LastEducation::all()
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
            'role' => 'required',
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
        $request['role_id'] = $request->role;
        $request['last_education_id'] = $request->last_education ?? NULL;

        if ($request->hasFile('picture')) {
            $request['image'] = $request->file('picture')->store('users', 'public');
        }

        User::create($request->all());

        return redirect(route('app.staff.index'))->with('success', 'Staff berhasil ditambahkan');
    }

    public function edit(User $staff)
    {
        $this->authorize('update staff');

        return view('manage.user.staff.edit', [
            'staff' => $staff,
            'roles' => Role::whereIn('name', ['staff', 'finance'])->get(),
            'last_educations' => LastEducation::all()
        ]);
    }

    public function update(User $staff, Request $request)
    {
        $this->authorize('update staff');

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $staff->id,
            'role' => 'required',
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

        $request->validate($rules);

        $request['role_id'] = $request->role;
        $request['last_education_id'] = $request->last_education ?? NULL;

        if ($request->hasFile('picture')) {
            Storage::disk('public')->delete($staff->image);
            $request['image'] = $request->file('picture')->store('users', 'public');
        }

        $staff->update($request->all());

        return redirect(route('app.staff.index'))->with('success', 'Staff berhasil diubah');
    }

    public function destroy(User $staff)
    {
        $this->authorize('delete staff');

        if ($staff->image !== NULL) {
            Storage::disk('public')->delete($staff->image);
        }

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
