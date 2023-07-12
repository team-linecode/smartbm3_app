<?php

namespace App\Http\Controllers\Manage;

use App\Models\WorkProgram;
use Illuminate\Http\Request;
use App\Models\ValueCriteria;
use App\Http\Controllers\Controller;
use App\Models\User;

class WorkProgramController extends Controller
{
    public function index()
    {
        $this->authorize('read work program');

        $work_programs = WorkProgram::all();
        return view('manage.work_program.index', [
            'work_programs' => $work_programs
        ]);
    }

    public function create()
    {
        $this->authorize('create work program');

        $user = User::find(auth()->user()->id);

        return view('manage.work_program.create', [
            'user' => $user,
            'users' => User::role('staff')->where('id', '!=', $user->id)->get(),
            'work_programs' => WorkProgram::all(),
            'value_criterias' => ValueCriteria::whereHas('category', function ($query) {
                $query->where('slug', 'sikap');
            })->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create work program');

        $request->validate([
            'name' => 'required',
            'success_indicator' => 'required',
            'criterias' => 'required'
        ]);

        $request['slug'] = Str::slug($request->name);

        WorkProgram::create($request->all());

        if ($request->stay) {
            $route = 'app.work_program.create';
        } else {
            $route = 'app.work_program.index';
        }

        return redirect()->route($route)->with('success', 'Program kerja berhasil ditambahkan');
    }

    public function edit(WorkProgram $work_program)
    {
        $this->authorize('update work program');

        return view('manage.work_program.edit', [
            'wp_category' => $work_program
        ]);
    }

    public function update(WorkProgram $work_program, Request $request)
    {
        $this->authorize('update work program');

        $wp_percentages = WorkProgram::sum('percentage');

        $request->validate([
            'name' => 'required|unique:work_programs,name, ' . $work_program->id,
            'percentage' => 'required|numeric|min:1|max:' . (100 - $wp_percentages) + $work_program->percentage
        ]);

        $request['slug'] = Str::slug($request->name);

        $work_program->update($request->all());

        return redirect()->route('app.work_program.index')->with('success', 'Program kerja berhasil diupdate');
    }

    public function destroy(WorkProgram $work_program)
    {
        $this->authorize('delete work program');

        $work_program->delete();

        return redirect()->route('app.work_program.index')->with('success', 'Program kerja berhasil dihapus');
    }
}
