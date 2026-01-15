<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;
use App\Models\Study;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $sd = Study::where('name', 'Software Developer')->first();

        ClassModel::insert([
            ['name' => 'SD2A', 'study_id' => $sd->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SD2B', 'study_id' => $sd->id, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}