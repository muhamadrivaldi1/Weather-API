<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->query('city', 'Jakarta');
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);

        // 📌 Tambahkan debug: tampilkan response asli kalau gagal
        if ($response->failed()) {
            return response()->json([
                'message' => 'Gagal mengambil data cuaca',
                'status_code' => $response->status(),
                'error' => $response->json()
            ], 500);
        }

        $data = $response->json();

        // Jika kota tidak ditemukan
        if (isset($data['cod']) && $data['cod'] == '404') {
            return response()->json(['message' => 'Kota tidak ditemukan'], 404);
        }

        return response()->json([
            'kota' => $data['name'],
            'cuaca' => $data['weather'][0]['description'],
            'suhu' => $data['main']['temp'] . ' °C',
            'kelembapan' => $data['main']['humidity'] . ' %'
        ]);
    }
}
