<?php

namespace App\Http\Controllers\Manage\Point;

use App\Models\PenaltyPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenaltyPointController extends Controller
{
    public function index()
    {
        return view('manage.point.penalty_point.index', [
            'penalty_points' => PenaltyPoint::all()
        ]);
    }

    public function create()
    {
        return view('manage.point.penalty_point.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:penalty_points,name',
            'point' => 'required|numeric|min:1|max:100'
        ]);

        $request['code'] = 'VAR' . random_int(1111, 9999);

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
            'penalty_point' => $penalty_point
        ]);
    }

    public function update(PenaltyPoint $penalty_point, Request $request)
    {
        $request->validate([
            'point' => 'required|numeric|min:1|max:100'
        ]);

        $penalty_point->update($request->only('name', 'point'));

        return redirect()->route('app.penalty_point.index')->with('success', 'Poin pelanggaran berhasil diubah');
    }

    public function destroy(PenaltyPoint $penalty_point)
    {
        $penalty_point->delete();
        return redirect()->route('app.penalty_point.index')->with('success', 'Poin pelanggaran berhasil dihapus');
    }
}
