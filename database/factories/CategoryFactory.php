<?php

namespace Database\Factories;

use Cknow\Money\Money;
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
        $category_assigned = Money::USD($this->faker->randomNumber(3));
        $category_activity = 0;
        $category_available = Money::USD($category_assigned)->subtract( Money::USD($category_activity));
        return [
            'category_name' => 'Mortgage',
            'category_assigned' => 0,
            'category_activity' => 0,
            'category_available' => 0,
        ];
    }
}
