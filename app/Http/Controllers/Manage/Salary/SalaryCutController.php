<?php

namespace App\Http\Controllers\Manage\Salary;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SalaryCut;

class SalaryCutController extends Controller
{
    public function index()
    {
        return view('manage.salary.salary_cut.index', [
            'salary_cuts' => SalaryCut::all()
        ]);
    }

    public function create()
    {
        return view('manage.salary.salary_cut.create');
    }

    public function store(Request $request)
    {
        $request['amount'] = cleanCurrency($request->amount);

        $request->validate([
            'name' => 'required|unique:users,name',
            'description' => 'required',
            'amount' => 'required|numeric'
        ]);

        $request['slug'] = Str::slug($request->name);

        if (formulaExists($request->description)) {
            $request['amount'] = NULL;
        }

        SalaryCut::create($request->all());

        return redirect(route('app.salary_cut.index'))->with('success', 'Potongan berhasil ditambahkan');
    }

    public function edit(SalaryCut $salary_cut)
    {
        return view('manage.salary.salary_cut.edit', [
            'salary_cut' => $salary_cut
        ]);
    }

    public function update(SalaryCut $salary_cut, Request $request)
    {
        $request['amount'] = cleanCurrency($request->amount);

        $request->validate([
            'name' => 'required|unique:users,name,' . $salary_cut->id,
            'description' => 'required',
            'amount' => 'required|numeric'
        ]);

        if (formulaExists($request->description)) {
            $request['amount'] = NULL;
        }

        $salary_cut->update($request->all());

        return redirect(route('app.salary_cut.index'))->with('success', 'Potongan berhasil diubah');
    }

    public function destroy(SalaryCut $salary_cut)
    {
        $salary_cut->delete();
        return redirect(route('app.salary_cut.index'))->with('success', 'Potongan berhasil dihapus');
    }
}
