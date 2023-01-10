<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('game_id');
            $table->foreignId('item_id');
            $table->string('player_id');
            $table->string('zone_id')->nullable();
            $table->integer('amount');
            $table->integer('total_harga');
            $table->foreignId('mtd_pembayaran_id');
            $table->string('no_hp');
            $table->enum('status', ['pending', 'done']);
            $table->time('waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
