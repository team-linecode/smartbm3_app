<?php

namespace App\Http\Controllers\Manage\Point;

use App\Models\User;
use App\Models\PenaltyPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserPoint;
use Carbon\Carbon;

use function GuzzleHttp\Promise\all;

class UserPointController extends Controller
{
    public function index()
    {
        return view('manage.point.user_point.index', [
            'user_points' => UserPoint::latest()->get()
        ]);
    }

    public function create()
    {
        return view('manage.point.user_point.create', [
            'penalty_points' => PenaltyPoint::all(),
            'users' => User::role('student')->get()
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'type' => 'required',
            'users' => 'required|array'
        ];

        if ($request->type == 'plus') {
            $rules['penalty_point'] = 'required';
        } else if ($request->type == 'minus') {
            $rules['description'] = 'required|max:100';
            $rules['point'] = 'required|numeric|min:0|max:100';
        }

        $request->validate($rules);

        $insertPoints = [];

        foreach ($request->users as $i => $user) {
            $insertPoints[$i]['user_id'] = $user;
            $insertPoints[$i]['type'] = $request->type;
            $insertPoints[$i]['date'] = date('Y-m-d H:i:s');
            $insertPoints[$i]['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $insertPoints[$i]['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            if ($request->type == 'plus') {
                $insertPoints[$i]['penalty_id'] = $request->penalty_point;

                $insertPoints[$i]['description'] = null;
                $insertPoints[$i]['point'] = null;
            } else if ($request->type == 'minus') {
                $insertPoints[$i]['description'] = $request->description;
                $insertPoints[$i]['point'] = $request->point;

                $insertPoints[$i]['penalty_id'] = null;
            }
        }

        UserPoint::insert($insertPoints);

        if ($request->stay) {
            $route = 'app.user_point.create';
        } else {
            $route = 'app.user_point.index';
        }

        return redirect()->route($route)->with('success', 'Poin berhasil ditambahkan');
    }

    public function edit(UserPoint $user_point)
    {
        return view('manage.point.user_point.edit', [
            'user_point' => $user_point,
            'penalty_points' => PenaltyPoint::all(),
            'users' => User::role('student')->get()
        ]);
    }

    public function update(UserPoint $user_point, Request $request)
    {
        $rules = [
            'type' => 'required',
        ];

        if ($request->type == 'plus') {
            $rules['penalty_point'] = 'required';
        } else if ($request->type == 'minus') {
            $rules['description'] = 'required|max:100';
            $rules['point'] = 'required|numeric|min:0|max:100';
        }

        $request->validate($rules);

        if ($request->type == 'plus') {
            $user_point->penalty_id = $request->penalty_point;

            $user_point->description = null;
            $request['description'] = null;
            $user_point->point = null;
        } else if ($request->type == 'minus') {
            $user_point->description = $request->description;
            $user_point->point = $request->point;

            $user_point->penalty_id = null;
        }

        $user_point->type = $request->type;
        $user_point->update($request->all());

        return redirect()->route('app.user_point.index')->with('success', 'Poin berhasil diubah');
    }

    public function destroy(UserPoint $user_point)
    {
        $user_point->delete();
        return back()->with('success', 'Poin berhasil dihapus');
    }
}
