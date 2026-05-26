<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Traits;

use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportPacket;

trait WithHttpClient
{
    private TransportInterface $transportLayer {
        get => resolve(TransportInterface::class);
    }

    private string $baseUrl;

    private function encodePathSegment(string $value): string
    {
        return rawurlencode($value);
    }

    private function setBaseUrl(string $url) : void
    {
        $this->baseUrl = $url;
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function request(string $method, string $url, array $payload = [], array $metadata = []): ActionResultInterface
    {
        $packet = new TransportPacket(
            endpoint: $url,
            payload: $payload,
            metadata: array_merge(['method' => $method], $metadata),
        );

        return $this->transportLayer->send($packet);
    }

    private function post(string $url, array $payload = [], array $metadata = []): ActionResultInterface
    {
        $uri = $this->buildUrl($url);
        return $this->request('post', $uri, $payload, $metadata);
    }

    private function get(string $url, array $payload = [], array $metadata = []): ActionResultInterface
    {
        $uri = $this->buildUrl($url);
        return $this->request('get', $uri, $payload, $metadata);
    }

    private function patch(string $url, array $payload = [], array $metadata = [])
    {
        $uri = $this->buildUrl($url);
        return $this->request('patch', $uri, $payload, $metadata);
    }

    private function buildUrl(string $param, string ...$params)
    {
        $allParams = array_merge([$param], $params);

        $url = $this->baseUrl;

        foreach($allParams as $_param) {
            $url .= "/{$_param}";
        }

        return $url;
    }
}