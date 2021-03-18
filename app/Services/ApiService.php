<?php


namespace App\Services;


use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ApiService
{
    protected Client $guzzleClient;

    /**
     * BreweryController constructor.
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $url
     * @return mixed
     * @throws Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(string $url)
    {
        $response = $this->guzzleClient->get($url);
        $this->checkApiResponse($response);
        return json_decode($response->getBody()->getContents(),true);
    }

    /**
     * @param ResponseInterface $response
     * @throws Exception
     */
    protected function checkApiResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new Exception('Brewery unavailable', $response->getStatusCode());
        }

        if ($response->getBody()->getSize() <= 0) {
            throw new Exception('Data is missing', 500);
        }
    }
}
