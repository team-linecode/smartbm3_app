<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('read role');

        $roles = Role::all();
        return view('manage.role.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $this->authorize('create role');

        $permissions = Permission::all();
        return view('manage.role.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create role');

        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);


        $request['name'] = strtolower($request['name']);

        $role = Role::create($request->only('name'));
        $role->givePermissionTo($request->permissions);

        return redirect()->route('app.role.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function edit(Role $role)
    {
        $this->authorize('update role');

        $permissions = Permission::all();
        return view('manage.role.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $this->authorize('update role');

        $request->validate([
            'name' => 'required|unique:roles,name, ' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update($request->all());
        $role->syncPermissions($request->permissions);

        return redirect()->route('app.role.index')->with('success', 'Role berhasil diupdate');
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete role');

        $role->syncPermissions([]);
        $role->delete();

        return redirect()->route('app.role.index')->with('success', 'Role berhasil dihapus');
    }
}
