<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBreweriesRequest;
use App\Http\Resources\BreweryResource;
use App\Models\Brewery;
use App\Services\ApiService;
use App\Services\BreweryService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class BreweryController extends Controller
{
    protected BreweryService $breweryService;
    protected ApiService     $apiService;
    const BREWERY_URL = 'https://api.openbrewerydb.org/';

    /**
     * BreweryController constructor.
     * @param ApiService $apiService
     * @param BreweryService $breweryService
     */
    public function __construct(ApiService $apiService, BreweryService $breweryService)
    {
        $this->breweryService = $breweryService;
        $this->apiService     = $apiService;
    }

    public function getBreweries(GetBreweriesRequest $request): JsonResponse
    {
        try {
            $url      = self::BREWERY_URL . 'breweries?page=' . $request->get('page', 1);
            $response = $this->apiService->send($url);
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json($e->getMessage(), $e->getCode());
        }
        return response()->json(BreweryResource::collection($this->breweryService->processBreweriesResponse($response)));
    }

    public function getBrewery($brewery): JsonResponse
    {
        try {
            $response = $this->apiService->send(self::BREWERY_URL . "breweries/$brewery");
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json($e->getMessage(), $e->getCode());
        }

        return response()->json(BreweryResource::make(new Brewery($response)));
    }
}
