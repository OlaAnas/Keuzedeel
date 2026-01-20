<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClassModel;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $class = ClassModel::where('name', 'SD2A')->first();

        Student::insert([
            [
                'student_number' => '1000001',
                'first_name' => 'Ola',
                'last_name' => 'Test',
                'email' => 'ola.student@example.com',
                'class_id' => $class->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_number' => '1000002',
                'first_name' => 'Joep',
                'last_name' => 'Test',
                'email' => 'joep.student@example.com',
                'class_id' => $class->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
