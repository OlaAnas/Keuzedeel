<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StudySeeder::class,
            ClassSeeder::class,
            PeriodSeeder::class,
            StudentSeeder::class,
            UserSeeder::class,
            KeuzedeelSeeder::class,
            CompletedKeuzedeelSeeder::class,
            EnrollmentSeeder::class,
        ]);
    }
}
