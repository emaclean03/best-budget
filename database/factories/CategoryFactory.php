<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_name' => 'Mortgage',
            'category_assigned' => $this->faker->randomNumber(3),
            'category_activity' => $this->faker->randomNumber(3),
            'category_available' => $this->faker->randomNumber(3),
        ];
    }
}
