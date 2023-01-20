<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fake()->numberBetween(1,5),
            'game_id' => fake()->numberBetween(1,5),
            'item_id' => fake()->numberBetween(1,10),
            'player_id' => fake()->name(),
            'zone_id' => '#' . fake()->randomNumber(4, true),
            'amount' => fake()->numberBetween(1,3),
            'total_harga' => fake()->randomNumber(6, true),
            'mtd_pembayaran_id' => fake()->numberBetween(1,5),
            'no_hp' => '+62' . fake()->randomNumber(9, true),
            'status' => fake()->randomElement(['pending' ,'done']),
            'waktu' => fake()->time(),
        ];
    }
}
