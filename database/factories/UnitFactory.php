<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $types = ['kanim'];

        return [
            'name'      => 'Kanim ' . fake()->city(),
            // 'type'     => fake()->randomElement(['kanim', 'rudenim', 'upt_lain']),
            'address'    => fake()->address(),
            'is_active' => true,
            'created_at'=> now(),
            'updated_at'=> now(),
        ];
    }

       
}
