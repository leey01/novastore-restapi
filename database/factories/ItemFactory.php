<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'game_id' => fake()->numberBetween(1,5),
            'item' => fake()->words(2, true),
            'price' => fake()->randomNumber(6, true),
            'pf_item' => 'item_picts/' . fake()->word() . '.png',
        ];
    }
}
