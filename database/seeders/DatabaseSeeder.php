<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolSeeder::class,
            DireccionSeeder::class,
            BicycleSeeder::class,
            AlquilerSeeder::class
        ]);

        User::factory()->create([
            'rol_id' => 1,
            'name' => 'Andres Echeverria',
            'email' => 'andres@gmail.com',
            'password' => Hash::make('123456'),
            'estrato' => 1
        ]);
    }
}
