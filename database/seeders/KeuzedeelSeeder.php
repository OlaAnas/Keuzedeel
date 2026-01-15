<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuzedeel;
use App\Models\Study;
use App\Models\Period;

class KeuzedeelSeeder extends Seeder
{
    public function run(): void
    {
        $study = Study::where('name', 'Software Developer')->first();
        $period = Period::first();

        Keuzedeel::insert([
            [
                'code' => '25604K0059',
                'name' => 'Verdieping Software',
                'description' => 'Extra verdieping in software development.',
                'repeatable' => true,
                'state' => 'active',
                'study_id' => $study->id,
                'period_id' => $period->id,
                'min_students' => 15,
                'max_students' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => '25604K0060',
                'name' => 'Basis Programmeren van Games',
                'description' => 'Introductie in game programming.',
                'repeatable' => false,
                'state' => 'active',
                'study_id' => $study->id,
                'period_id' => $period->id,
                'min_students' => 15,
                'max_students' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
