<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WorkProgramCategory;
use App\Http\Controllers\Controller;

class WorkProgramCategoryController extends Controller
{
    public function index()
    {
        $this->authorize('read work program category');

        $work_program_categories = WorkProgramCategory::all();
        return view('manage.work_program.category.index', [
            'work_program_categories' => $work_program_categories
        ]);
    }

    public function create()
    {
        $this->authorize('create work program category');

        return view('manage.work_program.category.create', [
            'work_program_categories' => WorkProgramCategory::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create work program category');

        $wp_percentages = WorkProgramCategory::sum('percentage');

        $request->validate([
            'name' => 'required|unique:work_program_categories,name',
            'percentage' => 'required|numeric|min:1|max:' . (100 - $wp_percentages),
        ]);

        $request['slug'] = Str::slug($request->name);

        WorkProgramCategory::create($request->all());

        if ($request->stay) {
            $route = 'app.work_program_category.create';
        } else {
            $route = 'app.work_program_category.index';
        }

        return redirect()->route($route)->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(WorkProgramCategory $work_program_category)
    {
        $this->authorize('update work program category');

        return view('manage.work_program.category.edit', [
            'wp_category' => $work_program_category
        ]);
    }

    public function update(WorkProgramCategory $work_program_category, Request $request)
    {
        $this->authorize('update work program category');

        $wp_percentages = WorkProgramCategory::sum('percentage');

        $request->validate([
            'name' => 'required|unique:work_program_categories,name, ' . $work_program_category->id,
            'percentage' => 'required|numeric|min:1|max:' . (100 - $wp_percentages) + $work_program_category->percentage
        ]);

        $request['slug'] = Str::slug($request->name);

        $work_program_category->update($request->all());

        return redirect()->route('app.work_program_category.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(WorkProgramCategory $work_program_category)
    {
        $this->authorize('delete work program category');

        $work_program_category->delete();

        return redirect()->route('app.work_program_category.index')->with('success', 'Kategori berhasil dihapus');
    }
}
