<?php

namespace Mmt\TradingServiceSdk\Platforms\B2Trader\Commands;

use Mmt\TradingServiceSdk\Contracts\CommandInterface;

class ExecutePerpetualOrderCommand implements CommandInterface
{
    public function __construct(
        /** ID de la cuenta B2Trader */
        public string $login,

        /** Símbolo a operar (ej: BTCUSD) */
        public string $symbol,

        /** Lado de la operación: BUY o SELL */
        public string $side,

        /** Volumen a operar en lotes */
        public float $volume,

        /** Precio límite de la orden (0.0 para órdenes de mercado) */
        public float $price,

        /** Nivel de stop loss */
        public float $sl,

        /** Nivel de take profit */
        public float $tp,

        /** Multiplicador de apalancamiento */
        public int $leverage,

        /** Comentario opcional */
        public ?string $comment = null,
    ) {}

    public function toArray(): array
    {
        $payload = [
            'login' => $this->login,
            'symbol' => $this->symbol,
            'side' => $this->side,
            'volume' => $this->volume,
            'price' => $this->price,
            'sl' => $this->sl,
            'tp' => $this->tp,
            'comment' => $this->comment,
            'leverage' => $this->leverage,
        ];

        return array_filter($payload, fn ($v) => ! is_null($v));
    }
}
