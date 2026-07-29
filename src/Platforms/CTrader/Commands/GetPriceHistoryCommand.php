<?php

namespace Mmt\TradingServiceSdk\Platforms\CTrader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;
use Override;

/**
 * Command to retrieve price history for a symbol.
 *
 * The symbol name is used as a URL path segment by the service
 * (GET /symbols/{name}/price-history) and is therefore NOT included
 * in the request body returned by toArray().
 */
class GetPriceHistoryCommand implements CommandInterface
{
    public function __construct(
        // Symbol name — accessed as $command->name by the service for path building
        public readonly string $name,

        // Required time range (Unix timestamps)
        public readonly int $from_ts,
        public readonly int $to_ts,

        // Optional maximum number of data points to return
        public readonly ?int $limit = null,
    ) {}

    /**
     * Return the request body fields as an associative array.
     * The symbol name is intentionally excluded (used as a path segment).
     * A null limit is stripped from the body.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(): array
    {
        $data = [
            'from_ts' => $this->from_ts,
            'to_ts'   => $this->to_ts,
        ];

        if ($this->limit !== null) {
            $data['limit'] = $this->limit;
        }

        return $data;
    }
}
