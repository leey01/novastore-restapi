<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\ProfileController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\PriceController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', function () {
    return 'ok';
})->middleware('auth:api');

Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth:api');


// Home
Route::group(['middleware' => ['auth:api'], 'prefix' => 'home'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/search', [HomeController::class, 'search']);
});

// Order
Route::group(['middleware' => ['auth:api'], 'prefix' => 'order'], function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/search', [OrderController::class, 'search']);
});

// Price
Route::group(['middleware' => ['auth:api'], 'prefix' => 'price'], function () {
    Route::get('/', [PriceController::class, 'index']);
    Route::get('/list-harga', [PriceController::class, 'listHarga']);
});

// Profile
Route::group(['middleware' => ['auth:api'], 'prefix' => 'profile'], function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::post('/edit-profile', [ProfileController::class, 'update']);
});

