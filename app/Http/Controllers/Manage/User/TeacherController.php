<?php

namespace App\Http\Controllers\Manage\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $this->authorize('developer access');

        return view('manage.user.teacher.index');
    }
}
