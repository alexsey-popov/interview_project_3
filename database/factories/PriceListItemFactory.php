<?php

namespace Database\Factories;

use App\Models\PriceList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceListItem>
 */
class PriceListItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $priceList = PriceList::inRandomOrder()->first();

        return [
            'price_list_id' => $priceList->id,
            'name' => $this->faker->word,
            'article_number' => $this->faker->bothify('?-####'),
            'price' => $this->faker->numberBetween($min = 100, $max = 10000)
        ];
    }
}
