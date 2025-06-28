<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Extracurricular;

class ExtracurricularSeeder extends Seeder
{
    public function run(): void
    {
        $extracurriculars = [
            ['name' => 'IT Club', 'description' => 'Ekskul teknologi dan pemrograman'],
            ['name' => 'Japanese Club', 'description' => 'Ekskul budaya dan bahasa Jepang'],
            ['name' => 'Drumband', 'description' => 'Ekskul drumband sekolah'],
            ['name' => 'Band', 'description' => 'Ekskul band musik sekolah'],
            ['name' => 'Basket', 'description' => 'Ekskul olahraga basket'],
            ['name' => 'Silat', 'description' => 'Ekskul bela diri silat'],
        ];

        foreach ($extracurriculars as $ekskul) {
            Extracurricular::create($ekskul);
        }
    }
}
