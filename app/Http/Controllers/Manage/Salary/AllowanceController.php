<?php

namespace App\Http\Controllers\Manage\Salary;

use App\Models\Allowance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LastEducation;

class AllowanceController extends Controller
{
    public function index()
    {
        return view('manage.salary.allowance.index', [
            'allowances' => Allowance::all()
        ]);
    }

    public function create()
    {
        return view('manage.salary.allowance.create', [
            'last_educations' => LastEducation::all()
        ]);
    }

    public function store(Request $request)
    {
        cleanCurrency($request->amount);

        $request->validate([
            'name' => 'required|unique:allowances,name',
            'description' => 'required',
            'amount' => 'numeric',
        ]);

        $request['slug'] = Str::slug($request->name);

        if (formulaExists($request->description)) {
            $request['amount'] = NULL;
        }

        Allowance::create($request->all());

        return redirect(route('app.allowance.index'))->with('success', 'Tunjangan berhasil ditambahkan');
    }

    public function edit(Allowance $allowance)
    {
        return view('manage.salary.allowance.edit', [
            'allowance' => $allowance,
        ]);
    }

    public function update(Allowance $allowance, Request $request)
    {
        cleanCurrency($request->amount);

        $request->validate([
            'name' => 'required|unique:allowances,name,' . $allowance->id,
            'description' => 'required',
            'amount' => 'numeric',
        ]);

        $request['slug'] = Str::slug($request->name);

        $allowance->update($request->all());

        return redirect(route('app.allowance.index'))->with('success', 'Tunjangan berhasil diubah');
    }

    public function destroy(Allowance $allowance)
    {
        $allowance->delete();

        return back()->with('success', 'Tunjangan berhasil dihapus');
    }
}
