<?php

namespace App\Contracts;

interface WeatherForecastServiceInterface {
    public function get_data($latitude, $longitude);
    public function map($data);
}
