<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Drivers\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ResponseResult;
use Mmt\TradingServiceSdk\Exceptions\TradingServiceRequestException;
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
        if ( !isset($packet->metadata['method'])) {
            throw new \Exception('Method is required');
        }

        return match($packet->metadata['method']) {
            'get' => $this->get($packet->endpoint, $packet->payload),
            'post' => $this->post($packet->endpoint, $packet->payload),
            default => throw new \Exception('Invalid method'),
        };
    }

    /**
     * @throws TradingServiceRequestException
     */
    private function get(string $uri, array $query = []): ResponseResult
    {
        try {
            $options = $query ? ['query' => $query] : [];
            $response = $this->http->get($uri, $options);

            $objectResponse = $this->decode($response->getBody()->getContents());

            $data = $objectResponse->data;

            return new ResponseResult(
                code: (string)$data->code,
                message: $data->message,
                data: $data->data,
                success:true,
            );

        } catch (RequestException $e) {

            $data = $this->decode($e->getResponse()->getBody()->getContents());

            return new ResponseResult(
                code: $e->getCode(),
                message: $data->message,
                success: false,
            );
        } catch (Throwable $e) {
            return new ResponseResult(
                code: 500,
                message: $e->getMessage(),
                success: false,
            );
        }
    }

    /**
     * @throws TradingServiceRequestException
     */
    private function post(string $uri, array $data = []): ResponseResult
    {
        try {
            $response = $this->http->post($uri, ['json' => $data]);

            $objectResponse = $this->decode($response->getBody()->getContents());

            $data = $objectResponse->data;

            return new ResponseResult(
                code: (string)$data->code,
                message: $data->message,
                data: $data->data,
                success: true,
            );
            
        } catch (RequestException|ClientException $e) {

            $body = $e->getResponse()->getBody();
            $data = $body ? $this->decode($body->getContents()) : (object)[];

            return new ResponseResult(
                code: (string)$data->code,
                message: $data?->message,
                success: false,
                errorDetails: $data?->detail ?? null,
            );

        } catch (Throwable $e) {
            return new ResponseResult(
                code: 500,
                message: $e->getMessage(),
                success: false,
            );
        }
    }

    private function decode(string $body): object
    {
        if ($body === '') {
            return (object)[];
        }

        return new class (json_decode($body, false, 512, JSON_THROW_ON_ERROR)) {
            public function __construct(
                public readonly ?object $data,
            ) {}

            public function __get(string $name): mixed
            {
                return $this->data?->$name ?? null;
            }
        };
    }
}
