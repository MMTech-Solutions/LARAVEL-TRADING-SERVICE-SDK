<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Drivers\Http;

use Mmt\TradingServiceSdk\TransportDrivers\Contracts\ActionResultInterface;

class ResponseResult implements ActionResultInterface
{
    public function __construct(
        private readonly string $code,
        private readonly bool $success,
        private readonly mixed $data = null,
        private readonly ?string $message = null,
        private readonly mixed $errorDetails = null,
        private readonly string $rawResponse = ''
    ) {}

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorDetails(): mixed
    {
        return $this->errorDetails;
    }

    public function getRawResponse(): string
    {
        return $this->rawResponse;
    }

    public static function fromSuccessResponse(string $rawResponse): ActionResultInterface
    {
        $decoded = json_decode($rawResponse, true, 512, JSON_THROW_ON_ERROR);

        $responseData = $decoded['data'] ?? null;

        return new self(
            code: $decoded['code'] ?? '',
            message: $decoded['message'] ?? null,
            data: is_array($responseData) && count($responseData) == 0 ? [] : (object)$responseData,
            success: true,
            rawResponse: $rawResponse,
        );
    }

    public static function fromErrorResponse(string $rawResponse): ActionResultInterface
    {
        $decoded = json_decode($rawResponse, true, 512, JSON_THROW_ON_ERROR);
        return new self(
            code: $decoded['code'] ?? 'NO_CODE',
            message: $decoded['message'] ?? null,
            success: false,
            errorDetails: $decoded['detail'],
            rawResponse: $rawResponse,
        );
    }
    
}