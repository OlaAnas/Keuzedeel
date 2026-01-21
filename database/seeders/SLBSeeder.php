<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SLBSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'SLB',
            'last_name' => 'User',
            'email' => 'slb@example.com',
            'password' => bcrypt('password'),
            'role' => 'slb',
        ]);
    }
}
