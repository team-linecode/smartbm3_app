<?php

namespace App\Http\Controllers\Manage\Salary;

use App\Models\User;
use App\Models\LastEducation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LastEducationController extends Controller
{
    public function index()
    {
        $this->authorize('read last education');

        return view('manage.salary.last_education.index', [
            'last_educations' => LastEducation::get()
        ]);
    }

    public function create()
    {
        $this->authorize('create last education');

        return view('manage.salary.last_education.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create last education');

        $request->validate([
            'name' => 'required|unique:last_educations,name',
            'alias' => 'required',
        ]);

        $request['slug'] = Str::slug($request->name);

        LastEducation::create($request->all());

        return redirect(route('app.last_education.index'))->with('success', 'Pendidikan terakhir berhasil ditambahkan');
    }

    public function edit(LastEducation $last_education)
    {
        $this->authorize('update last education');

        return view('manage.salary.last_education.edit', [
            'last_education' => $last_education
        ]);
    }

    public function update(LastEducation $last_education, Request $request)
    {
        $this->authorize('update last education');

        $request->validate([
            'name' => 'required|unique:last_educations,name,' . $last_education->id,
            'alias' => 'required',
            'salary' => 'required'
        ]);

        $request['slug'] = Str::slug($request->name);
        $request['salary'] = cleanCurrency($request->salary);

        $last_education->update($request->all());

        return redirect(route('app.last_education.index'))->with('success', 'Pendidikan terakhir berhasil diubah');
    }

    public function destroy(LastEducation $last_education)
    {
        $this->authorize('delete last education');

        $last_education->delete();

        $update_user = User::where('last_education_id', $last_education->id)->update(['last_education_id' => NULL]);

        if ($update_user) {
            return back()->with('success', 'Pendidikan terakhir berhasil dihapus');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
