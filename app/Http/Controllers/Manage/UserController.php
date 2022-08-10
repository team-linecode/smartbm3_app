<?php

namespace App\Http\Controllers\Manage;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\DummyData;

class UserController extends Controller
{
    public function index($role)
    {
        $this->authorize('developer access');

        return view('manage.user.' . $role, [
            'role' => $role,
            'role_alias' => ($role == 'teacher' ? 'Guru' : 'Siswa'),
        ]);
    }
}
