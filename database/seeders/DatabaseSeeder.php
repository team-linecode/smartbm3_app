<?php

namespace Database\Seeders;

use App\Models\Lesson;
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
        $currentDate = date('Y-m-d H:i:s');
        $lessons = [
            ['name' => 'Pendidikan Agama dan Budi Pekerti', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Matematika', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'B.Inggris', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'PKn', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Kewirausahaan', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'B. Sunda', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'B. Indonesia', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Sejarah', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Fisika', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Bahasa Asing : Jepang', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Seni Budaya', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'PJOK', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Kimia', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'KJD', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Pemrograman Dasar', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'DDG', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'PPL', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Basis Data', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'PBO', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'PWPB', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'WAN', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'AIJ', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'ASJ', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'TLJ', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'DGP', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'TVAV', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Animasi', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'DMI', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Bimbingan Konseling', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'BTQ', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'SISKOM', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Dasar Program Keahlian', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Dasar-dasar TJKT', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Pemrograman Terstruktur', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Perkembangan Teknologi & Isu Global pada DKV', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Penggunaan Alat Ukur Jaringan', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Orientasi dasar Pengembangan PLG', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Informatika', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Profile Technopreneur, Proses Bisnis Bidang DKV', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Projek IPAS', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Media & Jaringan Telekomunikasi', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Teknik Dasar Proses Produksi DKV', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Komputer Grafis', 'created_at' => $currentDate, 'updated_at' => $currentDate],
            ['name' => 'Proses Bisnis & Job Technopreneurship Bidang Keahlian', 'created_at' => $currentDate, 'updated_at' => $currentDate],
        ];

        Lesson::insert($lessons);

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
