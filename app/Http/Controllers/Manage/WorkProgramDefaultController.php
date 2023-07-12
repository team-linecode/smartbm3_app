<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WorkProgramDefault;
use App\Http\Controllers\Controller;
use App\Models\ValueCriteria;

class WorkProgramDefaultController extends Controller
{
    public function index()
    {
        $this->authorize('read work program category');

        $work_program_defaults = WorkProgramDefault::all();
        return view('manage.work_program.default.index', [
            'work_program_defaults' => $work_program_defaults
        ]);
    }

    public function create()
    {
        $this->authorize('create work program category');

        return view('manage.work_program.default.create', [
            'work_program_defaults' => WorkProgramDefault::all(),
            'value_criterias' => ValueCriteria::whereHas('category', function ($query) {
                $query->where('slug', 'sikap');
            })->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create work program category');

        $request->validate([
            'name' => 'required',
            'success_indicator' => 'required',
            'criterias' => 'required'
        ]);

        $request['slug'] = Str::slug($request->name);

        WorkProgramDefault::create($request->all());

        if ($request->stay) {
            $route = 'app.work_program_default.create';
        } else {
            $route = 'app.work_program_default.index';
        }

        return redirect()->route($route)->with('success', 'Program kerja berhasil ditambahkan');
    }

    public function edit(WorkProgramDefault $work_program_default)
    {
        $this->authorize('update work program category');

        return view('manage.work_program.default.edit', [
            'wp_category' => $work_program_default
        ]);
    }

    public function update(WorkProgramDefault $work_program_default, Request $request)
    {
        $this->authorize('update work program category');

        $wp_percentages = WorkProgramDefault::sum('percentage');

        $request->validate([
            'name' => 'required|unique:work_program_defaults,name, ' . $work_program_default->id,
            'percentage' => 'required|numeric|min:1|max:' . (100 - $wp_percentages) + $work_program_default->percentage
        ]);

        $request['slug'] = Str::slug($request->name);

        $work_program_default->update($request->all());

        return redirect()->route('app.work_program_default.index')->with('success', 'Program kerja berhasil diupdate');
    }

    public function destroy(WorkProgramDefault $work_program_default)
    {
        $this->authorize('delete work program category');

        $work_program_default->delete();

        return redirect()->route('app.work_program_default.index')->with('success', 'Program kerja berhasil dihapus');
    }
}
