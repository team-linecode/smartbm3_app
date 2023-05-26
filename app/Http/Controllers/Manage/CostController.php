<?php

namespace App\Http\Controllers\Manage;

use App\Models\Cost;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Classroom;
use App\Models\CostDetail;
use App\Models\Schoolyear;
use Illuminate\Support\Str;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CostController extends Controller
{
    public function index()
    {
        $this->authorize('read cost');

        return view('manage.finance.cost.index', [
            'schoolyears' => Schoolyear::orderBy('id', 'desc')->get()
        ]);
    }

    public function show(Schoolyear $schoolyear)
    {
        $this->authorize('read cost');

        return view('manage.finance.cost.show', [
            'cost_categories' => CostCategory::all(),
            'schoolyear' => $schoolyear,
        ]);
    }

    public function detail(Schoolyear $schoolyear, Cost $cost)
    {
        $this->authorize('read cost');

        return view('manage.finance.cost.detail', [
            'classrooms' => Classroom::all(),
            'schoolyear' => $schoolyear,
            'costs' => $schoolyear->costs,
            'cost' => $cost
        ]);
    }

    public function create(Schoolyear $schoolyear, CostCategory $cost_category)
    {
        $this->authorize('create cost');

        return view('manage.finance.cost.create', [
            'cost_categories' => CostCategory::all(),
            'cost_category' => $cost_category,
            'schoolyear' => $schoolyear,
            'classrooms' => Classroom::all(),
            'semesters' => Semester::all(),
            'groups' => Group::all()
        ]);
    }

    public function store(Schoolyear $schoolyear, CostCategory $cost_category, Request $request)
    {
        $this->authorize('create cost');

        $request->validate([
            'name' => 'required|unique:costs,name',
            'amounts.*' => 'required',
        ], [
            'name.required' => 'Nama biaya harus diisi',
            'name.unique' => 'Nama biaya sudah ada',
            'amounts.*.required' => 'Jumlah biaya harus diisi'
        ]);

        $request['slug'] = Str::slug($request->name);
        $request['schoolyear_id'] = $schoolyear->id;
        $request['cost_category_id'] = $cost_category->id;
        $cost = Cost::create($request->all());

        foreach ($request->amounts as $index => $amount) {
            if ($cost_category->slug == 'spp' || $cost_category->slug == 'daftar-ulang') {
                $data = [
                    'amount' => str_replace(',', '', $amount),
                    'cost_id' => $cost->id,
                    'classroom_id' => $index
                ];
            } else if ($cost_category->slug == 'ujian') {
                $data = [
                    'amount' => str_replace(',', '', $amount),
                    'cost_id' => $cost->id,
                    'semester_id' => $index
                ];
            } else if ($cost_category->slug == 'gedung') {
                $data = [
                    'amount' => str_replace(',', '', $amount),
                    'cost_id' => $cost->id,
                    'group_id' => $index
                ];
            } else if ($cost_category->slug == 'lain-lain') {
                $data = [
                    'amount' => str_replace(',', '', $amount),
                    'cost_id' => $cost->id
                ];
            }

            CostDetail::create($data);
        }

        return redirect(route('app.finance.cost.show', $schoolyear->slug))->with('success', 'Data berhasil disimpan');
    }

    public function edit(Schoolyear $schoolyear, Cost $cost)
    {
        $this->authorize('update cost');

        return view('manage.finance.cost.edit', [
            'cost_categories' => CostCategory::all(),
            'schoolyear' => $schoolyear,
            'classrooms' => Classroom::all(),
            'semesters' => Semester::all(),
            'groups' => Group::all(),
            'cost' => $cost
        ]);
    }

    public function update(Schoolyear $schoolyear, Cost $cost, Request $request)
    {
        $this->authorize('update cost');

        $request->validate([
            'name' => 'required|unique:costs,name,' . $cost->id,
            'amounts.*' => 'required',
        ], [
            'name.required' => 'Nama biaya harus diisi',
            'name.unique' => 'Nama biaya sudah ada',
            'amounts.*.required' => 'Jumlah biaya harus diisi'
        ]);

        $cost->update($request->all());

        foreach ($request->amounts as $index => $amount) {
            if ($cost->cost_category->slug == 'spp' || $cost->cost_category->slug == 'daftar-ulang') {
                $where = 'classroom_id';
            } else if ($cost->cost_category->slug == 'ujian') {
                $where = 'semester_id';
            } else if ($cost->cost_category->slug == 'lain-lain') {
                $where = 'group_id';
            }

            CostDetail::where('cost_id', $cost->id)
                ->where($where, $index)
                ->update(['amount' => str_replace(',', '', $amount)]);
        }

        return redirect(route('app.finance.cost.detail', [$schoolyear->slug, $cost->slug]))->with('success', 'Perubahan berhasil disimpan');
    }

    public function destroy(Schoolyear $schoolyear, Cost $cost)
    {
        $this->authorize('delete cost');

        CostDetail::where('cost_id', $cost->id)->delete();
        $cost->delete();

        return redirect(route('app.finance.cost.show', $schoolyear->slug))->with('success', 'Data berhasil dihapus');
    }

    public function _get_roles(Request $request)
    {
        $schoolyear = Schoolyear::where('slug', $request->schoolyear)->first();
        $schoolyears = Schoolyear::where('slug', '!=', $schoolyear->slug)->get();

        $options1 = '<option value="' . $schoolyear->slug . '">' . $schoolyear->name . '</option>';
        $options2 = '';

        foreach ($schoolyears as $sch_year) {
            $options2 .= '<option value="' . $sch_year->slug . '">' . $sch_year->name . '</option>';
        }

        if ($schoolyear) {
            return response()->json([
                'code' => 200,
                'data' => [
                    'options1' => $options1,
                    'options2' => $options2
                ]
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => []
            ]);
        }

        return "ok";
    }

    public function duplicate(Request $request)
    {
        $schoolyear = Schoolyear::where('slug', $request->schoolyear)->firstOrFail();
        $destination = Schoolyear::where('slug', $request->destination)->firstOrFail();

        foreach ($schoolyear->costs as $cost) {
            $create_cost = Cost::create([
                'name' => $cost->name,
                'slug' => Str::slug($cost->name),
                'schoolyear_id' => $destination->id,
                'cost_category_id' => $cost->cost_category_id
            ]);

            foreach ($cost->details as $cost_detail) {
                CostDetail::create([
                    'amount' => $cost_detail->amount,
                    'cost_id' => $create_cost->id,
                    'classroom_id' => $cost_detail->classroom_id,
                    'group_id' => $cost_detail->group_id,
                    'semester_id' => $cost_detail->semester_id
                ]);
            }
        }

        return back()->with('success', 'Data berhasil di duplikat');
    }
}
