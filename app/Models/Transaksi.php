<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'game_id', 'item_id', 'player_id', 'zone_id', 'amount', 'total_harga', 'mtd_pembayaran_id', 'no_hp', 'status', 'waktu'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');

     }

    public function game()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

}
