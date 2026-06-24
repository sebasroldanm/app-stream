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
        $this->proxyServer = rtrim(env('API_PROXY_SERVER'), '/');

        $this->client = new Client([
            'base_uri' => $this->apiServer,
            'verify' => false,
            'headers' => $this->getDefaultHeaders()
        ]);
    }

    /**
     * Defines the default headers in an isolated method
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36',
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
            'cookie' => env('COOKIE_SERVER'),
        ];
    }

    public function get(string $uri, array $options = []): Response
    {
        $maxRetries = 3;
        $baseDelay = 2;
        $attempt = 0;

        do {
            $attempt++;
            try {
                $enableProxy = $options['enable_proxy'] ?? $this->enableProxy;

                if ($enableProxy) {
                    $fullUrl = $this->apiServer . '/' . ltrim($uri, '/');
                    if (!empty($options['query'])) {
                        $fullUrl .= (str_contains($fullUrl, '?') ? '&' : '?') . http_build_query($options['query']);
                        unset($options['query']);
                    }

                    $specificHeaders = $options['headers'] ?? [];
                    $mergedHeaders = json_encode(array_merge($this->getDefaultHeaders(), $specificHeaders), JSON_UNESCAPED_SLASHES);

                    $queryParams = [
                        's' => $this->base64UrlEncode($fullUrl),
                        'h' => $this->base64UrlEncode($mergedHeaders)
                    ];

                    $requestUri = $this->proxyServer . '?' . http_build_query($queryParams, '', '&', PHP_QUERY_RFC3986);

                    $options['headers'] = [
                        'User-Agent' => 'Guzzle-Proxy-Client/1.0',
                        'Accept' => 'application/json'
                    ];
                } else {
                    $requestUri = $uri;
                }
                return $this->client->get($requestUri, $options);
            } catch (\Throwable $th) {
                if ($attempt >= $maxRetries) {
                    $this->logger->logError(
                        'service/owner_api_client',
                        $th->getMessage(),
                        ['uri' => $uri, 'requestUri' => $requestUri ?? '', 'options' => $options, 'attempt' => $attempt],
                        [],
                        $th->getTraceAsString()
                    );
                    throw $th;
                }

                $delay = $baseDelay * pow(2, $attempt - 1);
                $this->logger->logError(
                    'service/owner_api_client',
                    "Reintento {$attempt} de {$maxRetries} después de {$delay}s por error: " . $th->getMessage(),
                    ['uri' => $uri]
                );
                sleep($delay);
            }
        } while (true);
    }

    /**
     * Encode to URL-safe Base64 (RFC 4648)
     */
    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
