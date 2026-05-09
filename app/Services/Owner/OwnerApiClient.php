<?php

namespace App\Services\Owner;

use App\Services\Logger\ServiceLogger;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class OwnerApiClient
{
    protected Client $client;
    protected ServiceLogger $logger;
    protected string $apiServer;
    protected bool $enableProxy;
    protected string $proxyServer;

    public function __construct(ServiceLogger $logger)
    {
        $this->logger = $logger;
        $this->enableProxy = (bool) env('ENABLE_PROXY', false);
        $this->apiServer = rtrim(env('API_SERVER'), '/');
        $this->proxyServer = env('API_PROXY_SERVER');

        $this->client = new Client([
            'base_uri' => $this->apiServer,
            'verify' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
                'cookie'        => env('COOKIE_SERVER'),
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
        $requestUri = $uri;

        if ($this->enableProxy) {
            $fullUrl = $this->apiServer . '/' . ltrim($uri, '/');

            if (!empty($options['query'])) {
                $fullUrl .= (str_contains($fullUrl, '?') ? '&' : '?') . http_build_query($options['query']);
                unset($options['query']);
            }

            $requestUri = $this->proxyServer . base64_encode($fullUrl);
        }

        try {
            return $this->client->get($requestUri, $options);
        } catch (\Throwable $th) {
            $this->logger->logError(
                'service/owner_api_client',
                $th->getMessage(),
                ['uri' => $uri, 'requestUri' => $requestUri, 'options' => $options],
                [],
                $th->getTraceAsString()
            );
            throw $th;
        }
    }
}
