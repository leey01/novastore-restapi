<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) return response(['message' => 'user not found'], 401);
            if ($user->email == $request->email && Hash::check($request->password, $user->password)){
                $token = $user->createToken($user->name)->accessToken;

                return response()->json([
                    'messege' => 'success',
                    'user' => $user,
                    'token' => $token
                ], 200);

            } else {
                return response(['message' => 'wrong password'], 401);
            }
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 401);
        }
    }

    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'pf_avatar' => 'avatars_img/defaultavatar.jpg',
            'password' => Hash::make(request('password')),
            'no_hp' => request('no_hp'),
        ]);

        $token = $user->createToken($user->name)->accessToken;

        return response()
            ->json([
                'message' => 'register success',
                'data' => $user,
                'access_token' => $token,
            ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'message' => 'user logged out'
        ];
    }
}
