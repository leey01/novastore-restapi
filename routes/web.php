<?php

use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/form', [\App\Http\Controllers\Client\TransaksiController::class, 'index']);
Route::get('/payment', [\App\Http\Controllers\Client\TransaksiController::class, 'payment']);

// Google Auth
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('login', function () {
    return response([
        'status' => false,
        'message' => 'Unauthorized'
    ], 401);
})->name('login');
