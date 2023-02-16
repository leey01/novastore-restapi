<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Game;
use App\Models\Item;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Game::factory(5)->create();
        User::factory(5)->create();
        Item::factory(10)->create();
        Pembayaran::factory(5)->create();
    }
}
