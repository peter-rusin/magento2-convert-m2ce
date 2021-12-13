<?php
declare(strict_types=1);

namespace Convert\WeatherWidget\Api;

interface WeatherServiceInterface
{
    /**
     * @param string $city
     * @param string $countryId
     * @return WeatherApiResponseInterface
     */
    public function getWeatherForCity(string $city = 'Kraków', string $countryId = 'PL');
}
