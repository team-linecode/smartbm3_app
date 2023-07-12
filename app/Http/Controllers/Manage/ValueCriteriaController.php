<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ValueCriteria;
use App\Http\Controllers\Controller;
use App\Models\UsedCriteria;
use App\Models\WorkProgramCategory;

class ValueCriteriaController extends Controller
{
    public function index()
    {
        $this->authorize('read value criteria');

        $value_criterias = ValueCriteria::all();
        return view('manage.work_program.criteria.index', [
            'value_criterias' => $value_criterias
        ]);
    }

    public function create()
    {
        $this->authorize('create value criteria');

        return view('manage.work_program.criteria.create', [
            'work_program_categories' => WorkProgramCategory::orderByDesc('percentage')->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create value criteria');

        $request->validate([
            'category' => 'required',
            'name' => 'required|unique:value_criterias,name',
            'status' => 'required',
        ]);

        $request['work_program_category_id'] = $request->category;
        $value_criteria = ValueCriteria::create($request->all());

        if ($request->status == 'active') {
            UsedCriteria::create([
                'value_criteria_id' => $value_criteria->id
            ]);
        }

        if ($request->stay) {
            $route = 'app.value_criteria.create';
        } else {
            $route = 'app.value_criteria.index';
        }

        return redirect()->route($route)->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function edit(ValueCriteria $value_criterion)
    {
        $this->authorize('update value criteria');

        return view('manage.work_program.criteria.edit', [
            'value_criteria' => $value_criterion,
            'work_program_categories' => WorkProgramCategory::orderByDesc('percentage')->get()
        ]);
    }

    public function update(ValueCriteria $value_criterion, Request $request)
    {
        $this->authorize('update value criteria');

        $request->validate([
            'category' => 'required',
            'name' => 'required|unique:value_criterias,name,' . $value_criterion->id,
            'status' => 'required',
        ]);

        $request['work_program_category_id'] = $request->category;
        $value_criterion->update($request->all());

        $exist_used_criteria = UsedCriteria::where('value_criteria_id', $value_criterion->id)->first();
        if ($request->status == 'active') {
            if (!$exist_used_criteria) {
                UsedCriteria::create([
                    'value_criteria_id' => $value_criterion->id
                ]);
            }
        } else {
            if ($exist_used_criteria) {
                $exist_used_criteria->delete();
            }
        }

        return redirect()->route('app.value_criteria.index')->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function destroy(ValueCriteria $value_criterion)
    {
        $this->authorize('delete value criteria');

        $exist_used_criteria = UsedCriteria::where('value_criteria_id', $value_criterion->id)->first();
        if ($exist_used_criteria) {
            $exist_used_criteria->delete();
        }

        $value_criterion->delete();

        return redirect()->route('app.value_criteria.index')->with('success', 'Kriteria berhasil dihapus');
    }

    public function update_status(Request $request)
    {
        $status = $request->status;
        $criteria_id = $request->criteria_id;

        $value_criteria = ValueCriteria::find($criteria_id);

        if ($value_criteria) {
            $exist_used_criteria = UsedCriteria::where('value_criteria_id', $value_criteria->id)->first();

            if ($status == 'active') {
                if (!$exist_used_criteria) {
                    UsedCriteria::create([
                        'value_criteria_id' => $value_criteria->id
                    ]);
                }
            } else if ($status == 'nonactive') {
                if ($exist_used_criteria) {
                    $exist_used_criteria->delete();
                }
            } else {
                return response()->json(['status' => '400']);
            }

            $value_criteria->status = $status;
            $value_criteria->update();

            return response()->json(['status' => '200']);
        } else {
            return response()->json(['status' => '400']);
        }
    }
}
