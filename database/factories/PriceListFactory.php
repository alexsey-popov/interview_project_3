<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceList>
 */
class PriceListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'provider' => $this->faker->company,
            'validity period' => $this->faker->dateTimeBetween('+1 days', '+2 days'),
            'currency' => $this->faker->currencyCode,
        ];
    }
}
