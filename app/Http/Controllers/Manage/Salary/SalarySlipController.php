<?php

namespace App\Http\Controllers\Manage\Salary;

use App\Models\Salary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SalaryDetail;

class SalarySlipController extends Controller
{
    public function index()
    {
        $this->authorize('print salary');

        return view('manage.salary.slip.index', [
            'salaryDetails' => SalaryDetail::whereHas('salary', function($query) {
                $query->where('status', 'open');
            })->where('user_id', auth()->user()->id)->get()
        ]);
    }
}
