<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Contracts;

/**
 * @template T
 */
class ResponseResult
{
    public function __construct(
        private readonly string $code,
        /**
         * @var T
         */
        private readonly bool $success,
        private readonly mixed $data = null,
        private readonly ?string $message = null
    ) {}

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return T
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }
}