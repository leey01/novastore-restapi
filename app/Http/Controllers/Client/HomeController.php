<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\ItemResource;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use TheSeer\Tokenizer\Exception;
use App\Models\Transaksi;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $list = DB::table('games')->get();

            return response()->json([
                'data' => GameResource::collection($list)
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $list = DB::table('games')->where('id', $id)->first();
            // read list item by game_id
            $listItem = DB::table('items')->where('game_id', $id)->get();

            return response()->json([
                'data' => new GameResource($list),
                'item' => ItemResource::collection($listItem)
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e
            ], 500);
        }
    }

    public function createTransaksi(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'game_id' => 'required|integer',
            'item_id' => 'required|integer',
            'mtd_pembayaran_id' => 'required|integer',
            'amount' => 'required',
            'player_id' => 'required',
            'total_harga' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            $transaksi = Transaksi::create([
                'user_id' => Auth::user()->id,
                'game_id' => $request->game_id,
                'item_id' => $request->item_id,
                'player_id' => $request->player_id,
                'zone_id' => $request->zone_id,
                'amount' => $request->amount,
                'total_harga' => $request->total_harga,
                'mtd_pembayaran_id' => $request->mtd_pembayaran_id,
                'no_hp' => '',
                'status' => 'pending',
                'waktu' => Carbon::now()->format('Y-m-d H.i'),
            ]);

            return response()->json([
                'message' => 'Transaksi menunggu pembayaran',
                'data' => $transaksi
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->getMessage()
            ], $e->getCode());
        }

    }

    public function payTransaksi()
    {
        $validator = Validator::make(request()->all(),[
            'id' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            Transaksi::where('id', request()->id)->update([
                'no_hp' => request()->no_hp,
                'status' => 'done',
            ]);

            return response()->json([
                'message' => 'Transaksi dibayar',
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->getMessage()
            ], $e->getCode());
        }
    }

    // read data pembayaran
    public function listPembayaran()
    {
        $dataPembayaran = DB::table('pembayarans')
            ->get();

        return response()->json([
            'data' => $dataPembayaran
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $result = DB::table('games')
            ->where('nama', 'LIKE', '%'. $search .'%')
            ->orWhere('pengembang', 'LIKE', '%'. $search .'%')
            ->orWhere('genre', 'LIKE', '%'. $search .'%')
            ->orWhere('platform', 'LIKE', '%'. $search .'%')
            ->get();

        return response()->json([
            'search' => $search,
            'data' => GameResource::collection($result),
        ]);
    }
}
