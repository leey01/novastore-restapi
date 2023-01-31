<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    public function index()
    {
        $dataGame = DB::table('games')
            ->get();


        return response()->json([
            'data' => $dataGame,
        ]);
    }

    public function listHarga(Request $request)
    {
        is_null($request->id) ? $id = 1 : $id = $request->id;

        $dataHargaItem = DB::table('items')
            ->where('game_id', $id)
            ->get();

        return response()->json([
            'data' => $dataHargaItem
        ]);
    }
}
