<?php
declare(strict_types=1);

namespace Convert\WeatherWidget\Model;

use Convert\WeatherWidget\Api\WeatherApiResponseInterface;

class ApiResponse implements WeatherApiResponseInterface
{
    /** @var array */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /** @inheirtDoc  */
    public function getWeather(): ?string
    {
        return $this->data[self::WEATHER] ?? null;
    }

    /** @inheirtDoc  */
    public function getCity(): string
    {
        return $this->data[self::CITY];
    }

    /** @inheirtDoc  */
    public function getCountryId(): string
    {
        return $this->data[self::COUNTRY_ID];
    }
}
