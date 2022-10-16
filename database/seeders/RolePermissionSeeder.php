<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Role
        $r1 = Role::create(['name' => 'developer']);
        $r2 = Role::create(['name' => 'HOF']);
        $r3 = Role::create(['name' => 'principal']);
        $r4 = Role::create(['name' => 'staff']);
        $r5 = Role::create(['name' => 'teacher']);
        $r6 = Role::create(['name' => 'student']);

        // Create Permission
        $p1 = Permission::create(['name' => 'read role']);
        $p2 = Permission::create(['name' => 'create role']);
        $p3 = Permission::create(['name' => 'update role']);
        $p4 = Permission::create(['name' => 'delete role']);

        $p5 = Permission::create(['name' => 'read permission']);
        $p6 = Permission::create(['name' => 'create permission']);
        $p7 = Permission::create(['name' => 'update permission']);
        $p8 = Permission::create(['name' => 'delete permission']);

        $r1->givePermissionTo([$p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8]);
    }
}
