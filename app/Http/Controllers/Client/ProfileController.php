<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $historyPayment = Transaksi::with(['game', 'item'])
            ->where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now())
            ->get();

        $user->pf_avatar = Storage::disk('public')->url($user->pf_avatar);

        return response()->json([
            'data' => [
                'user' => $user,
                'history-payment' => $historyPayment,
            ]
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 403);
        }

        $user = User::find(Auth::user()->id);

        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        if ($request->avatar && $request->avatar->isValid()) {
            $file_name = date("dmYHi").$request->avatar->getClientOriginalName();
            Storage::disk('public')->put('avatars_img/'.$file_name, file_get_contents($request->avatar));
            $user->pf_avatar = 'avatars_img/' . date("dmYHi") . $request->avatar->getClientOriginalName();
        }
        $user->update();

        $token = $user->createToken($user->name)->accessToken;

        return response()->json([
            'message' => 'user updated!',
            'data' => $user,
            'access_token' => $token,
        ]);
    }
}
