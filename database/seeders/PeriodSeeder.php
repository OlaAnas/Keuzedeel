<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Period::create([
            'name' => 'Periode 1 - 2026',
            'start_date' => '2026-01-13',
            'end_date' => '2026-02-28',
            'enrollment_open' => true,
        ]);

        Period::create([
            'name' => 'Periode 2 - 2026',
            'start_date' => '2026-03-01',
            'end_date' => '2026-04-30',
            'enrollment_open' => false,
        ]);

        Period::create([
            'name' => 'Periode 3 - 2026',
            'start_date' => '2026-05-01',
            'end_date' => '2026-06-30',
            'enrollment_open' => false,
        ]);

        Period::create([
            'name' => 'Periode 4 - 2026',
            'start_date' => '2026-07-01',
            'end_date' => '2026-08-31',
            'enrollment_open' => false,
        ]);
    }
}
