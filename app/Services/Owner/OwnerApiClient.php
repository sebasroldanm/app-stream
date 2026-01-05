<?php

namespace App\Services\Owner;

use App\Services\Logger\ServiceLogger;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class OwnerApiClient
{
    protected Client $client;
    protected ServiceLogger $logger;

    public function __construct(ServiceLogger $logger)
    {
        $this->logger = $logger;
        $this->client = new Client([
            'base_uri' => env('API_SERVER'),
            'verify' => false,
            'headers' => [
                'User-Agent' => 'PostmanRuntime/7.39.0',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive'
            ]
        ]);
    }

    /**
     * Perform a GET request.
     *
     * @param string $uri
     * @param array $options
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $options = []): Response
    {
        try {
            return $this->client->get($uri, $options);
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_api_client',
                $th->getMessage(),
                ['uri' => $uri, 'options' => $options],
                [],
                $th->getTraceAsString()
            );
            throw $th;
        }
    }
}
