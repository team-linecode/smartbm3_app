<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // CREATE ROLE
        Role::create(['name' => 'developer']);
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'student']);
        Role::create(['name' => 'finance']);
        Role::create(['name' => 'staff']);

        // CREATE PERMISSION
        Permission::create(['name' => 'developer']); // 1
        Permission::create(['name' => 'teacher']); // 2
        Permission::create(['name' => 'student']); // 3
        Permission::create(['name' => 'finance']); // 4
        Permission::create(['name' => 'staff']); // 5

        // ASSIGN PERMISSION TO ROLE
        Role::where('name', 'developer')->first()->permissions()->attach([1]);
        Role::where('name', 'teacher')->first()->permissions()->attach([2]);
        Role::where('name', 'student')->first()->permissions()->attach([3]);
        Role::where('name', 'finance')->first()->permissions()->attach([4]);
        Role::where('name', 'staff')->first()->permissions()->attach([5]);
    }
}
