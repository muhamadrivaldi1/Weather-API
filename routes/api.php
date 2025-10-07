<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sinilah kamu mendaftarkan semua endpoint API untuk aplikasi kamu.
| File ini akan secara otomatis dimuat oleh RouteServiceProvider dan
| semua route akan memiliki prefix "/api".
|
*/

// Contoh route default Laravel untuk autentikasi Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 🌦️ Route untuk API Cuaca
Route::get('/weather', [WeatherController::class, 'getWeather']);
