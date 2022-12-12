<?php

namespace App\Http\Controllers\Manage;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillController extends Controller
{
    public function index()
    {
        $this->authorize('read bill');

        return view('manage.finance.bill.index');
    }

    public function show(User $user)
    {
        $this->authorize('read bill');

        return view('manage.finance.bill.show', [
            'user' => $user
        ]);
    }
}
