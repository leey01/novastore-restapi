<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $finduser = User::where('google_id', $user->id)->first();

        if ($finduser) {

            $token = $finduser->createToken($finduser->name)->accessToken;
            return response()->json([
                'status' => true,
                'data' => $user,
                'message' => 'Login Success',
                'token' => $token
            ], 200);
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->getId(),
                'password' => Hash::make('12345678'),
                'no_hp' => '08123456789',
                'pf_avatar' => $user->getAvatar()
            ]);


            $token = $newUser->createToken($newUser->name)->accessToken;
            return response()->json([
                'status' => true,
                'message' => 'Login Success',
                'token' => $token
            ], 200);
        }
    }
}
