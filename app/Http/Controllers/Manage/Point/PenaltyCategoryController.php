<?php

namespace App\Http\Controllers\Manage\Point;

use App\Http\Controllers\Controller;
use App\Models\PenaltyCategory;
use Illuminate\Http\Request;

class PenaltyCategoryController extends Controller
{
    public function index()
    {
        return view('manage.point.penalty_category.index', [
            'penalty_categories' => PenaltyCategory::all()
        ]);
    }

    public function create()
    {
        return view('manage.point.penalty_category.create');
    }

    public function store(Request $request)
    {
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
        return view('manage.point.penalty_category.edit', [
            'penalty_category' => $penalty_category
        ]);
    }

    public function update(PenaltyCategory $penalty_category, Request $request)
    {
        $request->validate([
            'point' => 'required|numeric|min:1|max:100'
        ]);

        $penalty_category->update($request->only('name', 'point'));

        return redirect()->route('app.penalty_category.index')->with('success', 'Kategori berhasil diubah');
    }

    public function destroy(PenaltyCategory $penalty_category)
    {
        $penalty_category->delete();
        return redirect()->route('app.penalty_category.index')->with('success', 'Kategori berhasil dihapus');
    }
}
