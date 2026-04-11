<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Drivers\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportPacket;
use Throwable;

class TradingServiceHttpClient implements TransportInterface
{
    private readonly Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => config('laravel-trading-service-sdk.base_url'),
            'headers'  => array_merge([
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ]),
        ]);
    }

    public function send(TransportPacket $packet): ResponseResult
    {
        if (! isset($packet->metadata['method'])) {
            throw new \Exception('Method is required');
        }

        $metadata = $packet->metadata;

        return match ($metadata['method']) {
            'get' => $this->get($packet->endpoint, $packet->payload, $metadata),
            'post' => $this->post($packet->endpoint, $packet->payload, $metadata),
            'patch' => $this->patch($packet->endpoint, $packet->payload, $metadata),
            default => throw new \Exception('Invalid method'),
        };
    }

    /**
     * @param array<string, mixed> $metadata
     * @return array<string, mixed>
     */
    private function clientOptions(array $metadata, array $extra = []): array
    {
        if (isset($metadata['timeout'])) {
            $extra['timeout'] = (float) $metadata['timeout'];
        }

        return $extra;
    }

    private function decode(string $body): object
    {
        if ($body === '') {
            return $this->wrapDecoded(null);
        }

        $decoded = json_decode($body, false, 512, JSON_THROW_ON_ERROR);

        return $this->wrapDecoded(is_object($decoded) ? $decoded : null);
    }

    private function wrapDecoded(?object $root): object
    {
        return new class ($root) {
            public function __construct(
                public readonly ?object $data,
            ) {}

            public function __get(string $name): mixed
            {
                return $this->data?->$name ?? null;
            }
        };
    }

    private function responseFromHttpException(RequestException|ClientException $e): ResponseResult
    {
        $response = $e->getResponse();
        if ($response === null) {
            return new ResponseResult(
                code: (string) $e->getCode(),
                message: $e->getMessage(),
                success: false,
            );
        }

        $contents = $response->getBody()->getContents();
        $data = $this->decode($contents);

        return new ResponseResult(
            code: $data->code !== null && $data->code !== '' ? (string) $data->code : (string) $response->getStatusCode(),
            message: $data->message,
            success: false,
            errorDetails: $data->detail ?? null,
        );
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function get(string $uri, array $query = [], array $metadata = []): ResponseResult
    {
        try {
            $options = $this->clientOptions(
                $metadata,
                $query !== [] ? ['query' => $query] : []
            );
            $response = $this->http->get($uri, $options);

            $objectResponse = $this->decode($response->getBody()->getContents());
            $data = $objectResponse->data;

            return new ResponseResult(
                code: (string) $data->code,
                message: $data->message,
                data: $data->data,
                success: true,
            );
        } catch (RequestException|ClientException $e) {
            return $this->responseFromHttpException($e);
        } catch (Throwable $e) {
            return new ResponseResult(
                code: '500',
                message: $e->getMessage(),
                success: false,
            );
        }
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function post(string $uri, array $data = [], array $metadata = []): ResponseResult
    {
        try {
            $options = $this->clientOptions($metadata, ['json' => $data]);
            $response = $this->http->post($uri, $options);

            $objectResponse = $this->decode($response->getBody()->getContents());
            $data = $objectResponse->data;

            return new ResponseResult(
                code: (string) $data->code,
                message: $data->message,
                data: $data->data,
                success: true,
            );
        } catch (RequestException|ClientException $e) {
            return $this->responseFromHttpException($e);
        } catch (Throwable $e) {
            return new ResponseResult(
                code: '500',
                message: $e->getMessage(),
                success: false,
            );
        }
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function patch(string $uri, array $data = [], array $metadata = []): ResponseResult
    {
        try {
            $options = $this->clientOptions($metadata, ['json' => $data]);
            $response = $this->http->patch($uri, $options);

            $objectResponse = $this->decode($response->getBody()->getContents());
            $data = $objectResponse->data;

            return new ResponseResult(
                code: (string) $data->code,
                message: $data->message,
                data: $data->data,
                success: true,
            );
        } catch (RequestException|ClientException $e) {
            return $this->responseFromHttpException($e);
        } catch (Throwable $e) {
            return new ResponseResult(
                code: '500',
                message: $e->getMessage(),
                success: false,
            );
        }
    }
}
