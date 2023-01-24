<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $data = DB::table('transaksis')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $result = Transaksi::whereHas('user', function ($q) use($search) {
            $q->where('name', 'like', '%'. $search .'%');
        })->orWhere('id', $search)->get();

        return response()->json([
            'data' => $result
        ]);
    }
}
