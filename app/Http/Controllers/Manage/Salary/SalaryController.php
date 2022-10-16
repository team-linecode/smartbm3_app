<?php

namespace App\Http\Controllers\Manage\Salary;

use App\Models\User;
use App\Models\Salary;
use App\Models\Allowance;
use App\Models\SalaryCut;
use Illuminate\Support\Str;
use App\Models\SalaryDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create salary|read salary|update salary|delete salary|print salary']);
    }

    public function index()
    {
        $this->authorize('read salary');

        return view('manage.salary.index', [
            'salaries' => Salary::orderBy('month')->get()
        ]);
    }

    public function show(Salary $salary)
    {
        $this->authorize('read salary');

        return view('manage.salary.show', [
            'salary' => $salary
        ]);
    }

    public function create()
    {
        $this->authorize('create salary');

        $users = User::role(['staff', 'teacher'])->orderBy('name')->get();

        return view('manage.salary.create', [
            'users' => $users,
            'allowances' => Allowance::all(),
            'salary_cuts' => SalaryCut::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create salary');

        $request->validate([
            'month' => 'required|date|unique:salaries,month',
            'status' => 'required'
        ]);

        if (!$request->users) {
            return back()->with('error', 'Harap mencentang Staff / Guru');
        }

        $salary = Salary::create($request->only('month', 'status'));

        $insert = [];
        $components = [];

        foreach ($request->users as $indexUser => $user) {
            // Allowance
            foreach ($request->allowances[$user] as $allowanceId => $allowance) {
                $_allowance = Allowance::find($allowanceId);

                $components[$user]['allowances'][] = [
                    'allowance_id' => $allowanceId,
                    'name' => $_allowance->name,
                    'amount' => (int) cleanCurrency($allowance)
                ];
            }
            // Salary Cuts
            foreach ($request->salary_cuts[$user] as $salaryCutsId => $salary_cut) {
                $_salary_cut = SalaryCut::find($salaryCutsId);

                $components[$user]['salary_cuts'][] = [
                    'salary_cut_id' => $salaryCutsId,
                    'name' => $_salary_cut->name,
                    'amount' => (int) cleanCurrency($salary_cut)
                ];
            }

            $insert[] = [
                'uid' => Str::uuid(),
                'components' => json_encode($components[$user]),
                'user_id' => $user,
                'salary_id' => $salary->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        SalaryDetail::insert($insert);

        return redirect(route('app.salaries.index'))->with('success', 'Penggajian Berhasil Dibuat');
    }

    public function edit(Salary $salary)
    {
        $this->authorize('update salary');

        $users = User::role(['staff', 'teacher'])->orderBy('name')->get();

        return view('manage.salary.edit', [
            'users' => $users,
            'salary' => $salary,
            'salaryDetails' => SalaryDetail::where('salary_id', $salary->id)->get(),
            'allowances' => Allowance::all(),
            'salary_cuts' => SalaryCut::all()
        ]);
    }

    public function update(Salary $salary, Request $request)
    {
        $this->authorize('update salary');

        $request->validate([
            'month' => 'required|date|unique:salaries,month,' . $salary->id,
            'status' => 'required'
        ]);

        if (!$request->users) {
            return back()->with('error', 'Harap mencentang Staff / Guru');
        }

        $update = [];
        $components = [];

        foreach ($request->users as $indexUser => $user) {
            // Allowance
            foreach ($request->allowances[$user] as $allowanceId => $allowance) {
                $_allowance = Allowance::find($allowanceId);

                $components[$user]['allowances'][] = [
                    'allowance_id' => $allowanceId,
                    'name' => $_allowance->name,
                    'amount' => (int) cleanCurrency($allowance)
                ];
            }
            // Salary Cuts
            foreach ($request->salary_cuts[$user] as $salaryCutsId => $salary_cut) {
                $_salary_cut = SalaryCut::find($salaryCutsId);

                $components[$user]['salary_cuts'][] = [
                    'salary_cut_id' => $salaryCutsId,
                    'name' => $_salary_cut->name,
                    'amount' => (int) cleanCurrency($salary_cut)
                ];
            }

            $update[] = [
                'uid' => Str::uuid(),
                'components' => json_encode($components[$user]),
                'user_id' => $user,
                'salary_id' => $salary->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function destroy(Salary $salary)
    {
        $this->authorize('delete salary');

        $salary->details()->delete();
        $salary->delete();

        return redirect(route('app.salaries.index'))->with('success', 'Penggajian Berhasil Dihapus');
    }

    public function generatePDF(SalaryDetail $salary_detail, $type)
    {
        $this->authorize('print salary');

        $detail = SalaryDetail::where('id', $salary_detail->id)->with('user')->first();

        $data = [
            'salary' => $detail->salary->toArray(),
            'detail' => $detail->toArray(),
            'components' => json_decode($detail->components, true),
            'user' => $detail->user->toArray(),
            'role' => $detail->user->roles->first()->toArray(),
            'last_education' => $detail->user->last_education->toArray(),
            'positions' => $detail->user->positions->toArray(),
        ];

        if ($detail) {
            view()->share('data', $data);
            $pdf = PDF::loadView('manage.salary.pdf', $data)->setPaper('F4', 'landscape');
            $salary_month = strtolower(date('F_Y', strtotime($data['salary']['month'])));

            switch ($type) {
                case 'stream':
                    return $pdf->stream('slip_gaji_' . $salary_month . '.pdf');
                    break;
                case 'download':
                    return $pdf->download('slip_gaji_' . $salary_month . '.pdf');
                    break;
                default:
                    abort('404');
                    break;
            }
        } else {
            abort('404');
        }
    }
}
