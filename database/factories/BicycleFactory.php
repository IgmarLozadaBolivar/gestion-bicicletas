<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Bicycle>
 */
class BicycleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'marca' => $this->faker->company(),
            'modelo' => strtoupper($this->faker->bothify('MOD-###')),
            'color' => $this->faker->randomElement(['Rojo', 'Negro', 'Verde', 'Blanco', 'Azul', 'Gris']),
            'latitude' => $this->faker->latitude(11.4, 11.16),
            'longitude' => $this->faker->longitude(-72.95, -72.85),
            'estado' => $this->faker->randomElement(['Disponible', 'No Disponible']),
            'precio' => $this->faker->numberBetween(1000, 5000)
        ];
    }
}
