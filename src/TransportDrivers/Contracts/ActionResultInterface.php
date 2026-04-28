<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Contracts;

/**
 * @template T
 */
interface ActionResultInterface
{
    public function isSuccess(): bool;
    public function isFailure(): bool;
    public function getCode(): string;
    public function getMessage(): ?string;
    /**
     * @param class-string<T>|null $castToFqcn
     * @return T
     */
    public function getData(?string $castToFqcn = null): mixed;

    public function getErrorDetails(): mixed;
    public function getRawResponse(): string;
}