<?php

namespace App\Http\Controllers\Manage\Salary;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Allowance;

class SalaryController extends Controller
{
    public function index()
    {
        return view('manage.salary.index');
    }

    public function create()
    {
        $users = User::whereHas('role', function ($q) {
            $q->whereIn('name', ['staff', 'teacher']);
        })->orderBy('name')->get();

        return view('manage.salary.create', [
            'users' => $users,
            'allowances' => Allowance::all()
        ]);
    }
}
