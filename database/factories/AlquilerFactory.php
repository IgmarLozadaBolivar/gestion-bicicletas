<?php

namespace Database\Factories;

use App\Models\Bicycle;
use App\Models\Direccion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alquiler>
 */
class AlquilerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        $start_time = $this->faker->dateTimeBetween('today', 'now');
        $end_time = clone ($start_time)->modify('+' . rand(1, 5) . ' hours');

        $valor_principal = $this->faker->numberBetween(1000, 5000);

        $valor_adicional = $this->faker->boolean(30) ? $this->faker->numberBetween(1000, 2000) : 0;

        $user = User::inRandomOrder()->first();

        $estrato = $user->estrato;

        $descuento = match (true) {
            $estrato <= 2 => 0.10,
            $estrato === 3 => 0.5,
            $estrato === 4 => 0.05,
            default => 0.00
        };

        $valor_descuento = $valor_principal * (1 - $descuento);
        $valor_total = $valor_descuento + $valor_adicional;


        return [
            'user_id' => $user->id,
            'bicycle_id' => Bicycle::inRandomOrder()->first()->id,
            'direccion_id' => Direccion::inRandomOrder()->first()->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'valor_principal' => $valor_descuento,
            'valor_adicional' => $valor_adicional,
            'valor_total' => $valor_total,
            'metodo_pago' => $this->faker->randomElement(['Efectivo', 'Transferencia', 'Tarjeta'])
        ];
    }
}
