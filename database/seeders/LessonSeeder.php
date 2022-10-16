<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
    }
}
