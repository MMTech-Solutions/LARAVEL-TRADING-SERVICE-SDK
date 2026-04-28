<?php

namespace Mmt\TradingServiceSdk\TransportDrivers\Contracts;

use Mmt\TradingServiceSdk\WireHydration\Attributes\WireMapped;
use Mmt\TradingServiceSdk\WireHydration\WireHydrator;

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
     * @param  class-string<T>|null  $castToFqcn
     * @return T
     */
    public function getData(?string $castToFqcn = null): mixed;

    /**
     * Hydrates decoded payload using {@see WireHydrator}
     * and {@see WireMapped}.
     *
     * @template H of object
     *
     * @param  class-string<H>|null  $castToFqcn
     * @return ($castToFqcn is null ? mixed : (H|list<H>))
     */
    public function getMappedData(?string $castToFqcn = null): mixed;

    public function getErrorDetails(): mixed;

    public function getRawResponse(): string;
}
