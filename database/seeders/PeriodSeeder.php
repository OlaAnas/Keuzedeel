<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        Period::insert([
            [
                'name' => 'Periode 2 2025/2026',
                'start_date' => '2025-11-01',
                'end_date' => '2026-01-31',
                'enrollment_open' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
