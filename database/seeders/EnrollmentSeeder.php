<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Keuzedeel;
use App\Models\Period;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $joep = Student::where('student_number', '1000002')->first();
        $period = Period::first();

        $keuzedeel = Keuzedeel::where('code', '25604K0059')->first();

        Enrollment::create([
            'student_id' => $joep->id,
            'period_id' => $period->id,
            'keuzedeel_id' => $keuzedeel->id,
            'choice_number' => 1,
            'status' => 'pending',
        ]);
    }
}
