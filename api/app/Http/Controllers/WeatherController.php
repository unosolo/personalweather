<?php

namespace App\Http\Controllers;

use App\Services\WeatherGovForecastService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected WeatherGovForecastService $weatherService;

    public function __construct(WeatherGovForecastService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function get_data($latitude, $longitude)
    {
        $data = $this->weatherService->get_data($latitude, $longitude);

        if(empty($data)){
            return response()->json(null, 404);
        }

        return response()->json($data);
    }
}
