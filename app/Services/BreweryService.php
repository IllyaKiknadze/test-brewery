<?php


namespace App\Services;


use App\Models\Brewery;
use Psr\Http\Message\ResponseInterface;

class BreweryService
{
    public function processBreweriesResponse(array $breweries): ?array
    {
        foreach ($breweries as &$brewery) {
            $brewery = new Brewery($brewery);
        }

        return $breweries;
    }
}
