<?php
declare(strict_types=1);

namespace Convert\WeatherWidget\Service;

use Convert\WeatherWidget\Api\WeatherApiResponseInterface as ApiResponse;
use Convert\WeatherWidget\Api\WeatherApiResponseInterfaceFactory;
use Convert\WeatherWidget\Api\WeatherServiceInterface;
use Convert\WeatherWidget\Model\ApiRequest;
use Convert\WeatherWidget\Model\Config;

class OpenWeatherMapApiService implements WeatherServiceInterface
{
    const API_REQUEST_URI = 'https://api.openweathermap.org/data/2.5/';

    /** @var ApiRequest */
    private $apiRequest;

    /** @var Config */
    private $config;

    /** @var WeatherApiResponseInterfaceFactory */
    private $apiResponseFactory;

    public function __construct(
        ApiRequest $apiRequest,
        Config $config,
        WeatherApiResponseInterfaceFactory $apiResponseFactory
    ) {
        $this->apiRequest = $apiRequest;
        $this->config = $config;
        $this->apiResponseFactory = $apiResponseFactory;
    }

    /** @inheirtDoc */
    public function getWeatherForCity(?string $city = null, ?string $countryId = null): ApiResponse
    {
        $city = $city ?? $this->config->getDefaultCity();
        $countryId = $countryId ?? $this->config->getDefaultCountry();

        $response = $this->apiRequest->execute('weather', [
            'query' => [
                'q' => sprintf('%s, %s', $city, $countryId),
                'appid' => $this->config->getOpenWeatherMapApiKey()
            ]
        ]);

        return $this->apiResponseFactory->create([
            'data' => [
                ApiResponse::CITY => $city,
                ApiResponse::COUNTRY_ID => $countryId,
                ApiResponse::WEATHER => implode(
                    ', ',
                    array_column($response['weather'], 'description')
                )
            ]
        ]);
    }
}
