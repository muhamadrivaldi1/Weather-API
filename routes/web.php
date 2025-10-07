<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ini adalah tempat untuk mendaftarkan semua rute web aplikasi Laravel.
| Rute berikut menampilkan halaman utama dan halaman cuaca.
|
*/

// Halaman default Laravel (welcome)
Route::get('/', function () {
    return view('welcome');
});

// ✅ Halaman cuaca (Vue.js CDN)
Route::get('/weather', function () {
    return view('weather'); // arahkan ke resources/views/weather.blade.php
});

// ✅ Endpoint API cuaca
Route::get('/api/weather', [WeatherController::class, 'getWeather']);
