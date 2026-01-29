<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuzedeel;

class KeuzedelenSeeder extends Seeder
{
    public function run(): void
    {
        Keuzedeel::create([
            'code' => '25604K0060',
            'name' => 'Example Keuzedeel',
            'description' => 'Test description',
            'min_students' => 15,
            'max_students' => 30,
            'active' => true,
        ]);
    }
}
