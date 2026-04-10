<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Drivers\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;
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

            $data = $this->decode($response->getBody()->getContents());

            return new ResponseResult(
                code: $data->code,
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
            // if(Str::endsWith($uri, '/users')) {
            //     dd(json_encode($data));
            // }
            $response = $this->http->post($uri, ['json' => $data]);

            $data = $this->decode($response->getBody()->getContents());

            return new ResponseResult(
                code: $data->code,
                message: $data->message,
                data: $data->data,
                success: true,
            );
            
        } catch (RequestException $e) {

            $body = $e->getResponse()->getBody();
            $data = $body ? $this->decode($body->getContents()) : (object)[];
            
            return new ResponseResult(
                code: ((string)$data->code ?? '500'),
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

    private function decode(string $body): object
    {
        if ($body === '') {
            return (object)[];
        }

        return json_decode($body, false, 512, JSON_THROW_ON_ERROR);
    }
}
