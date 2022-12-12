<?php

namespace App\Http\Controllers\Manage\Salary;

use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class PositionController extends Controller
{
    public function index()
    {
        $this->authorize('read position');

        return view('manage.salary.position.index', [
            'positions' => Position::orderByDesc('name')->get()
        ]);
    }

    public function create()
    {
        $this->authorize('create position');

        return view('manage.salary.position.create', [
            'users' => User::whereHas('role', function ($q) {
                $q->whereIn('name', ['teacher', 'staff', 'finance']);
            })->orderByDesc('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create position');

        $request->validate([
            'user' => 'array|min:1',
            'name' => 'required|unique:positions,name',
            'salary' => 'required'
        ]);

        $request['slug'] = Str::slug($request->name);
        $request['salary'] = cleanCurrency($request->salary);

        $position = Position::create($request->all());
        $position->users()->attach($request->user);

        return redirect(route('app.position.index'))->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit(Position $position)
    {
        $this->authorize('update position');

        return view('manage.salary.position.edit', [
            'position' => $position,
            'users' => User::whereHas('role', function ($q) {
                $q->whereIn('name', ['teacher', 'staff', 'finance']);
            })->orderByDesc('name')->get()
        ]);
    }

    public function update(Position $position, Request $request)
    {
        $this->authorize('update position');

        $request->validate([
            'user' => 'array|min:1',
            'name' => 'required|unique:positions,name,' . $position->id,
            'salary' => 'required'
        ]);

        $position->users()->sync($request->user);

        $request['slug'] = Str::slug($request->name);
        $request['salary'] = cleanCurrency($request->salary);

        $position->update($request->all());

        return redirect(route('app.position.index'))->with('success', 'Jabatan berhasil diubah');
    }

    public function destroy(Position $position)
    {
        $this->authorize('delete position');

        $position->delete();
        $position->users()->detach();

        return back()->with('success', 'Jabatan berhasil dihapus');
    }

    public function destroy_user(Position $position, User $user)
    {
        $this->authorize('delete position');

        $user->positions()->detach($position->id);
        return back()->with('success', 'Anggota berhasil dihapus dari jabatan');
    }
}
