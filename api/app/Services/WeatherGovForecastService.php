<?php

namespace App\Services;

use App\Contracts\WeatherForecastServiceInterface;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherGovForecastService implements WeatherForecastServiceInterface
{
    private static string $weather_api_base = 'https://api.weather.gov';

    public function get_data($latitude, $longitude)
    {
        // find in redis the grid code by the coordinates
        $point_cache_id = "weather:point:{$latitude}:{$longitude}";
        $grid_cache_id = Cache::get($point_cache_id);

        if (!empty($grid_cache_id)) {
            // get the grid data if the grid id exists
            $mapped_data = Cache::get($grid_cache_id);

            if(!empty($mapped_data)) { // the data has not expired return it
               return json_decode($mapped_data, true);
            }
        }

        // find grid code from the Weather service
        $point_data = self::get_point($latitude, $longitude);

        if(empty($point_data)){
            return [];
        }

        $grid_cache_id = Cache::get($point_data['grid_cache_id']);

        if (!empty($grid_cache_id)) {
            $mapped_data = Cache::get($grid_cache_id);
            return json_decode($mapped_data, true);
        }

        $with_forecast_data = self::add_weather_forecast_data($point_data);

        $mapped_data = $this->map($with_forecast_data);

        $grid_cache_id = self::create_grid_cache_id($point_data);

        Cache::put($point_cache_id, $grid_cache_id);

        Cache::put($grid_cache_id, json_encode($mapped_data), 3600 );

        return $mapped_data;
    }

    public static function get_point($latitude, $longitude) {
        $api = self::$weather_api_base. "/points/{$latitude},{$longitude}";

        $point_response = Http::get($api);

        $point_data = json_decode($point_response->body(), true);

        if(!empty($point_data['status']) && $point_data['status'] !== 200) {
            return [];
        }

        $point_data['grid_cache_id'] = self::create_grid_cache_id($point_data);

        return $point_data;
    }

    public static function create_grid_cache_id( $point_data ): string {
        $properties = $point_data['properties'];
        $grid = $properties['gridId'] . ':' . $properties['gridX'] . ':' . $properties['gridY'];

        return  "weather:grid:{$grid}";
    }

    /**
     * @param $point_data
     *
     * @return array
     */
    public static function add_weather_forecast_data($point_data): array {
        $forecast_response = Http::get($point_data['properties']['forecast']);
        $point_data['forecast'] = json_decode($forecast_response->body(), true);

        $forecast_hourly_response = Http::get($point_data['properties']['forecastHourly']);
        $point_data['forecastHourly'] = json_decode($forecast_hourly_response->body(), true);

        return $point_data;
    }

    public function map($data): array {
        return [
            "city" => $data['properties']['relativeLocation']['properties']['city'],
            "state" => $data['properties']['relativeLocation']['properties']['state'],
            "forecast" => $data['forecast']['properties']['periods'],
            "forecastHourly" => $data['forecastHourly']['properties']['periods'],
        ];
    }
}
