<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorize('developer access');

        $permissions = Permission::all();
        return view('manage.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        $this->authorize('developer access');

        $permissions = Permission::all();
        return view('manage.permission.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('developer access');

        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $request['name'] = strtolower($request['name']);

        Permission::create($request->all());

        return redirect()->route('app.permission.index')->with('success', 'Permission berhasil ditambahkan');
    }

    public function edit(Permission $permission)
    {
        $this->authorize('developer access');

        $permissions = Permission::all();
        return view('manage.permission.edit', [
            'permission' => $permission,
            'permissions' => $permissions
        ]);
    }

    public function update(Permission $permission, Request $request)
    {
        $this->authorize('developer access');

        $request->validate([
            'name' => 'required|unique:permissions,name, ' . $permission->id,
        ]);

        $request['name'] = strtolower($request['name']);

        $permission->update($request->all());

        return redirect()->route('app.permission.index')->with('success', 'Permission berhasil diperbarui');
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('developer access');

        $permission->delete();
        $permission->roles()->detach();

        return redirect()->route('app.permission.index')->with('success', 'Permission berhasil dihapus');
    }
}
