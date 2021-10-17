<?php

namespace Shopapp\Services\ExchangeService;

/**
`EUR:USD` - `1:1.14`, `EUR:GBP` - `1:0.88`
 */
class ExchangeService implements ExchangeServiceInterface
{
    /**
     * @var float[] $rates
     */
    private array $rates;

    public function __construct()
    {
        $this->rates = [
            'EUR:USD' => 1.14,
            'EUR:GBP' => 0.88,
        ];
    }

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float
     */
    public function convert(string $from, string $to, float $amount): float
    {
        $key  = $from . ':' . $to;
        $key2 = $to . ':' . $from;

        /**
         * of course this is not perfect, precision will differ between different currencies (e.g. JPY will have 0)
         *  and we should be more careful with floating points, e.g. use cents and bcmul...
         */
        if (isset($this->rates[$key2])) {
            return round($amount / $this->rates[$key2], 2);
        }

        return isset($this->rates[$key])
            ? round($amount * $this->rates[$key], 2)
            : $amount;
    }
}
