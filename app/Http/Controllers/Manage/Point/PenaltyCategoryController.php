<?php

namespace App\Http\Controllers\Manage\Point;

use App\Http\Controllers\Controller;
use App\Models\PenaltyCategory;
use Illuminate\Http\Request;

class PenaltyCategoryController extends Controller
{
    public function index()
    {
        $this->authorize('read penalty category');

        return view('manage.point.penalty_category.index', [
            'penalty_categories' => PenaltyCategory::all()
        ]);
    }

    public function create()
    {
        $this->authorize('create penalty category');

        return view('manage.point.penalty_category.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create penalty category');

        $request->validate([
            'name' => 'required|unique:penalty_categories,name',
        ]);

        $request['code'] = getPenaltyCategoryCode();
        $request['name'] = ucwords($request->name);

        if (PenaltyCategory::where('code', $request->code)->first()) {
            return back()->with('error', 'Error: Silahkan coba lagi!');
        }

        PenaltyCategory::create($request->all());

        if ($request->stay) {
            $route = 'app.penalty_category.create';
        } else {
            $route = 'app.penalty_category.index';
        }

        return redirect()->route($route)->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(PenaltyCategory $penalty_category)
    {
        $this->authorize('update penalty category');

        return view('manage.point.penalty_category.edit', [
            'penalty_category' => $penalty_category
        ]);
    }

    public function update(PenaltyCategory $penalty_category, Request $request)
    {
        $this->authorize('update penalty category');

        $request->validate([
            'name' => 'required|unique:penalty_categories,name,' . $penalty_category->id,
        ]);

        $request['name'] = ucwords($request->name);
        $penalty_category->update($request->only('name'));

        return redirect()->route('app.penalty_category.index')->with('success', 'Kategori berhasil diubah');
    }

    public function destroy(PenaltyCategory $penalty_category)
    {
        $this->authorize('delete penalty category');

        $penalty_category->delete();
        return redirect()->route('app.penalty_category.index')->with('success', 'Kategori berhasil dihapus');
    }
}
