<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Contracts;

/**
 * @template T
 */
interface ActionResultInterface
{
    public function isSuccess(): bool;
    public function getCode(): string;
    public function getMessage(): ?string;
    /**
     * @return T
     */
    public function getData(): mixed;

    public function getErrorDetails(): mixed;
    public function getRawResponse(): string;
}