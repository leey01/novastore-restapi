<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

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
