<?php

namespace App\Http\Controllers\Manage\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $this->authorize('developer access');

        return view('manage.user.staff.index');
    }
}
