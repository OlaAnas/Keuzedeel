<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Student',
            'last_name' => 'User',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'student_number' => 'S123456',
        ]);
    }
}
