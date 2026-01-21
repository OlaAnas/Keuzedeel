<?php

namespace Database\Seeders;

use App\Models\Study;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Study::create(['name' => 'Software Development']);
        Study::create(['name' => 'Web Development']);
        Study::create(['name' => 'Information Technology']);
    }
}
