<?php

namespace Mmt\TradingServiceSdk\Platforms\MT5\ObjectResponses;

class PositionItem
{
    /**
     * @var string ID del ticket de posición.
     */
    public string $id;

    /**
     * @var string Login de la cuenta (propietario de la posición).
     */
    public string $login;

    /**
     * @var string Símbolo, por ejemplo "EURUSD".
     */
    public string $symbol;

    /**
     * @var float Volumen en lotes.
     */
    public float $volume = 0;

    /**
     * @var float Precio de apertura.
     */
    public float $open_price = 0;

    /**
     * @var float Precio actual.
     */
    public float $current_price = 0;

    /**
     * @var float Stop loss (0 = ninguno).
     */
    public float $sl = 0;

    /**
     * @var float Take profit (0 = ninguno).
     */
    public float $tp = 0;

    /**
     * @var float Swap.
     */
    public float $swap = 0;

    /**
     * @var float Ganancia/pérdida flotante.
     */
    public float $profit = 0;

    /**
     * @var string Comentario de la posición.
     */
    public string $comment;

    /**
     * @var string Hora de apertura ("TimeCreate") en UTC ISO 8601, ej. "2026-03-23T20:50:23Z".
     */
    public string $time;

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        $item = new self();

        $item->id = (string)($data['id'] ?? '');
        $item->login = (string)($data['login'] ?? '');
        $item->symbol = (string)($data['symbol'] ?? '');
        $item->volume = isset($data['volume']) ? (float)$data['volume'] : 0.0;
        $item->open_price = isset($data['open_price']) ? (float)$data['open_price'] : 0.0;
        $item->current_price = isset($data['current_price']) ? (float)$data['current_price'] : 0.0;
        $item->sl = isset($data['sl']) ? (float)$data['sl'] : 0.0;
        $item->tp = isset($data['tp']) ? (float)$data['tp'] : 0.0;
        $item->swap = isset($data['swap']) ? (float)$data['swap'] : 0.0;
        $item->profit = isset($data['profit']) ? (float)$data['profit'] : 0.0;
        $item->comment = (string)($data['comment'] ?? '');
        $item->time = (string)($data['time'] ?? '');

        return $item;
    }
}