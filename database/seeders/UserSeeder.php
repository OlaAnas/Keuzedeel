<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Student users
        $ola = Student::where('student_number', '1000001')->first();
        $joep = Student::where('student_number', '1000002')->first();

        User::create([
            'name' => 'Ola Student',
            'email' => 'ola.student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => $ola->id,
            'must_change_password' => false,
        ]);

        User::create([
            'name' => 'Joep Student',
            'email' => 'joep.student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => $joep->id,
            'must_change_password' => false,
        ]);
    }
}
