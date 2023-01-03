<?php

namespace App\Http\Controllers\Manage\Point;

use App\Models\PenaltyPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PenaltyCategory;

class PenaltyPointController extends Controller
{
    public function index()
    {
        return view('manage.point.penalty_point.index', [
            'penalty_points' => PenaltyPoint::orderBy('code')->get()
        ]);
    }

    public function create()
    {
        return view('manage.point.penalty_point.create', [
            'penalty_categories' => PenaltyCategory::orderBy('code')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penalty_category' => 'required',
            'name' => 'required|unique:penalty_points,name',
            'point' => 'required|numeric|min:1|max:100'
        ]);

        $penalty_point_code = getPenaltyPointCode(PenaltyCategory::find($request->penalty_category)->code ?? null);
        if ($penalty_point_code == false) {
            abort('404');
        }

        $request['code'] = $penalty_point_code;
        $request['name'] = ucfirst($request->name);
        $request['penalty_category_id'] = $request->penalty_category;

        if (PenaltyPoint::where('code', $request->code)->first()) {
            return back()->with('error', 'Error: Silahkan coba lagi!');
        }

        PenaltyPoint::create($request->all());

        if ($request->stay) {
            $route = 'app.penalty_point.create';
        } else {
            $route = 'app.penalty_point.index';
        }

        return redirect()->route($route)->with('success', 'Poin pelanggaran berhasil ditambahkan');
    }

    public function edit(PenaltyPoint $penalty_point)
    {
        return view('manage.point.penalty_point.edit', [
            'penalty_categories' => PenaltyCategory::orderBy('code')->get(),
            'penalty_point' => $penalty_point
        ]);
    }

    public function update(PenaltyPoint $penalty_point, Request $request)
    {
        $request->validate([
            'penalty_category' => 'required',
            'name' => 'required|unique:penalty_points,name,' . $penalty_point->id,
            'point' => 'required|numeric|min:1|max:100'
        ]);

        if ($request->penalty_category != $penalty_point->penalty_category_id) {
            $get_penalty_point = PenaltyPoint::whereHas('category', function ($penalty_category) use ($penalty_point) {
                $penalty_category->where('code', $penalty_point->category->code);
            })->where('code', '>', $penalty_point->code)->get();

            foreach ($get_penalty_point as $pp) {
                $pp->code = substr($pp->code, 0, 1) . '.' . (substr($pp->code, 2, 1) - 1);
                $pp->update();
            }

            $penalty_point_code = getPenaltyPointCode(PenaltyCategory::find($request->penalty_category)->code ?? null);
            if ($penalty_point_code == false) {
                abort('404');
            }

            $request['code'] = $penalty_point_code;
            $request['penalty_category_id'] = $request->penalty_category;
        }

        $request['name'] = ucfirst($request->name);

        $penalty_point->update($request->all());

        return redirect()->route('app.penalty_point.index')->with('success', 'Poin pelanggaran berhasil diubah');
    }

    public function destroy(PenaltyPoint $penalty_point)
    {
        $penalty_point->delete();
        return redirect()->route('app.penalty_point.index')->with('success', 'Poin pelanggaran berhasil dihapus');
    }
}
