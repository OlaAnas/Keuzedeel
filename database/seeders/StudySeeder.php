<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Study;

class StudySeeder extends Seeder
{
    public function run(): void
    {
        Study::insert([
            ['name' => 'Software Developer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Logistiek', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}