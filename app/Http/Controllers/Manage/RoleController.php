<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('developer access');

        $roles = Role::all();
        return view('manage.role.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $this->authorize('developer access');

        $permissions = Permission::all();
        return view('manage.role.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('developer access');

        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $request['name'] = strtolower($request['name']);

        $role = Role::create($request->all());
        $role->permissions()->attach($request->permissions);

        return redirect()->route('app.role.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function edit(Role $role)
    {
        $this->authorize('developer access');

        $permissions = Permission::all();
        return view('manage.role.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $this->authorize('developer access');

        $request->validate([
            'name' => 'required|unique:roles,name, ' . $role->id,
            'permissions' => 'array'
        ]);

        $permissions = (array) $request['permissions'];

        if ($role->default_permission_id()) {
            $request['name'] = strtolower($request['name']);
            array_push($permissions, (string) $role->default_permission_id());
            sort($permissions);
        }

        $role->update($request->all());
        $role->permissions()->sync($permissions);

        return redirect()->route('app.role.index')->with('success', 'Role berhasil diperbarui');
    }

    public function destroy(Role $role)
    {
        $this->authorize('developer access');

        $role->delete();
        $role->permissions()->detach();
        return redirect()->route('app.role.index')->with('success', 'Role berhasil dihapus');
    }
}
