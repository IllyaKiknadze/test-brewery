<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBreweriesRequest;
use App\Http\Resources\BreweryResource;
use App\Models\Brewery;
use App\Services\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class BreweryController extends Controller
{
    protected ApiService $apiService;
    const BREWERY_URL = 'https://api.openbrewerydb.org/';

    /**
     * BreweryController constructor.
     * @param ApiService $apiService
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getBreweries(GetBreweriesRequest $request): JsonResponse
    {
        try {
            $url      = self::BREWERY_URL . 'breweries?page=' . $request->get('page', 1);
            $response = $this->apiService->send($url);
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        foreach ($response as &$brewery) {
            $brewery = new Brewery($brewery);
        }

        return response()->json(BreweryResource::collection($response));
    }

    public function getBrewery($brewery): JsonResponse
    {
        try {
            $response = $this->apiService->send(self::BREWERY_URL . "breweries/$brewery");
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json(BreweryResource::make(new Brewery($response)));
    }
}
