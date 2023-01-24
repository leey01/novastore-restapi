<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $list = DB::table('games')->get();

            return response()->json([
                'data' => $list
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e
            ], 500);
        }
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
            'data' => $result,
        ]);
    }
}
