<?php

declare(strict_types=1);

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Wire payload for B2Trader POST accounts/access (SetAccessBody).
 */
final class SetAccountAccessCommand implements CommandInterface
{
    public function __construct(
        public readonly string $login,
        public readonly string $access,
    ) {}

    #[Override]
    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'access' => $this->access,
        ];
    }
}
