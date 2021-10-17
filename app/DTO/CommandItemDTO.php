<?php

namespace Shopapp\DTO;

use Exception;

class CommandItemDTO
{
    /**
     * @var string $id
     */
    private string $id;

    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var int $quantity
     */
    private int $quantity;

    /**
     * @var float $price
     */
    private float $price;

    /**
     * @var string $currency
     */
    private string $currency;

    /**
     * @param array $items
     * @throws Exception
     */
    public function __construct(array $items)
    {
        if (count($items) !== 5) {
            throw new Exception('Unexpected array size in CommandItemDTO constructor');
        }

        $this->id = $items[0];
        $this->name = $items[1];
        $this->quantity = (int)$items[2];
        $this->price = (float) $items[3];
        $this->currency = $items[4];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
