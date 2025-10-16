<?php

namespace Database\Seeders;

use App\Models\Alquiler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlquilerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alquiler::factory()->count(5)->create();
    }
}
