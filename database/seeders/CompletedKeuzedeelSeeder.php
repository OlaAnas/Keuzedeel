<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompletedKeuzedeel;
use App\Models\Student;

class CompletedKeuzedeelSeeder extends Seeder
{
    public function run(): void
    {
        $ola = Student::where('student_number', '1000001')->first();

        CompletedKeuzedeel::create([
            'student_id' => $ola->id,
            'keuzedeel_code' => '25604K0060',
            'completed_at' => '2025-06-01',
            'source' => 'import',
        ]);
    }
}
