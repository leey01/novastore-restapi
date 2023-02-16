<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('form_payment');
    }

    public function payment(Request $request)
    {
        $order_id = date('YmdHis').random_int(100, 999);
        $transaksi = Transaksi::create([
            'id' => $order_id,
            'user_id' => isset(Auth::user()->id) ? Auth::user()->id : null,
            'game_id' => $request->game_id,
            'item_id' => $request->item_id,
            'id_user' => $request->id_user,
            'id_zone' => isset($request->id_zone) ? $request->id_zone : null,
            'harga' => $request->harga.'.00',
            'no_hp' => isset($request->no_hp) ? $request->no_hp : null,
            'status' => 'Pending',
            'waktu' => Carbon::now()->format('Y-m-d H.i'),
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-5JeYIiH234q21WgEg581HS-m';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order_id,
                'gross_amount' => $transaksi->harga,
                'payment_amounts' => $transaksi->harga,
            ),
            'customer_details' => array(
                'first_name' => $transaksi->id_user,
                'phone' => $transaksi->no_hp,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('payment',[
            'snap_token'=>$snapToken,
        ]);
    }

    public function callback(Request $request)
    {
        $json = json_decode($request->getContent());

        $signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($signature_key != $json->signature_key) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature key'
            ], 400);
        }

        $transaksi = Transaksi::where('id', $json->order_id)->first();

        return $transaksi->update(['status' => 'Done']);
    }
}
