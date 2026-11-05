<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

/**
 * Payload for GET /users/{login}/expert-advisor (MT5).
 */
final class ExpertAdvisorItem
{
    public function __construct(
        public string $login,
        public bool $enabled,
    ) {}
}
