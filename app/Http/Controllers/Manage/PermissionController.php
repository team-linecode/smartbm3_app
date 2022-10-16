<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorize('read permission');

        $permissions = Permission::all();
        return view('manage.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        $this->authorize('create permission');

        $permissions = Permission::all();
        return view('manage.permission.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create permission');

        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $request['name'] = strtolower($request['name']);

        Permission::create($request->only('name'));

        if ($request->stay) {
            $route = 'app.permission.create';
        } else {
            $route = 'app.permission.index';
        }

        return redirect()->route($route)->with('success', 'Permission berhasil ditambahkan');
    }

    public function edit(Permission $permission)
    {
        $this->authorize('update permission');

        $permissions = Permission::all();
        return view('manage.permission.edit', [
            'permission' => $permission,
            'permissions' => $permissions
        ]);
    }

    public function update(Permission $permission, Request $request)
    {
        $this->authorize('update permission');

        $request->validate([
            'name' => 'required|unique:permissions,name, ' . $permission->id,
        ]);

        $request['name'] = strtolower($request['name']);

        $permission->update($request->all());

        return redirect()->route('app.permission.index')->with('success', 'Permission berhasil diupdate');
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete permission');

        $permission->delete();
        $permission->roles()->detach();

        return redirect()->route('app.permission.index')->with('success', 'Permission berhasil dihapus');
    }
}
