<?php

namespace App\Http\Controllers\Manage\Salary;

use App\Models\Allowance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AllowanceDetail;
use App\Models\LastEducation;
use Carbon\Carbon;

class AllowanceController extends Controller
{
    public function index()
    {
        session()->forget('input_session');

        return view('manage.salary.allowance.index', [
            'allowances' => Allowance::orderByDesc('name')->get()
        ]);
    }

    public function create()
    {
        if (!session('input_session')) {
            session()->put('input_session', [
                'number' => 1
            ]);
        }

        return view('manage.salary.allowance.create', [
            'last_educations' => LastEducation::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:allowances,name',
            'description.*' => 'required',
            'last_education.*' => 'unique:allowance_details,last_education_id',
            'salary.*' => 'required',
        ], [
            'last_education.*.unique' => 'Pend. terakhir ini sudah digunakan.'
        ]);

        $request['slug'] = Str::slug($request->name);

        $new_allowance = Allowance::create($request->all());

        for ($i = 0; $i < count($request->description); $i++) {
            $details[] = [
                'description' => $request->description[$i],
                'last_education_id' => $request->last_education[$i],
                'allowance_id' => $new_allowance->id,
                'salary' => cleanCurrency($request->salary[$i]),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
        }

        AllowanceDetail::insert($details);

        return redirect(route('app.allowance.index'))->with('success', 'Tunjangan berhasil ditambahkan');
    }

    public function edit(Allowance $allowance)
    {
        if (!session('input_session')) {
            session()->put('input_session', [
                'number' => 1
            ]);
        }

        return view('manage.salary.allowance.edit', [
            'allowance' => $allowance,
            'last_educations' => LastEducation::all()
        ]);
    }

    public function update(Allowance $allowance, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:allowances,name,' . $allowance->id,
        ]);

        $request['slug'] = Str::slug($request->slug);

        $allowance->update($request->all());

        return redirect(route('app.allowance.index'))->with('success', 'Tunjangan berhasil diubah');
    }

    public function destroy(Allowance $allowance)
    {
        $allowance->delete();

        return back()->with('success', 'Tunjangan berhasil dihapus');
    }

    public function add_input()
    {
        if (session('input_session')['number'] >= 20) {
            return response()->json(['status' => 500]);
        } else {
            session()->put('input_session', [
                'number' => (session('input_session')['number'] + 1)
            ]);

            return response()->json(['status' => 200]);
        }
    }

    public function remove_input()
    {
        if (session('input_session')['number'] <= 1) {
            return response()->json(['status' => 500]);
        } else {
            session()->put('input_session', [
                'number' => (session('input_session')['number'] - 1)
            ]);

            return response()->json(['status' => 200]);
        }
    }

    public function reset_input()
    {
        session()->put('input_session', [
            'number' => 1
        ]);

        return response()->json(['status' => 200]);
    }
}
