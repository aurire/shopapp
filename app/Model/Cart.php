<?php

namespace Shopapp\Model;

use Shopapp\DTO\CommandItemDTO;
use Shopapp\Services\EventsService\EventsService;
use Shopapp\Services\ExchangeService\ExchangeService;
use Shopapp\Services\OutputService\CartOutputInterface;

class Cart
{
    /**
     * @var array $items
     */
    private array $items = [];

    /**
     * @var EventsService $eventsService
     */
    private EventsService $eventsService;

    /**
     * @var ExchangeService $exchangeService
     */
    private ExchangeService $exchangeService;

    /**
     * @var string $defaultCurrency
     */
    private string $defaultCurrency;

    /**
     * @param EventsService $eventsService
     * @param ExchangeService $exchangeService
     */
    public function __construct(EventsService $eventsService, ExchangeService $exchangeService, string $defaultCurrency)
    {
        $this->eventsService = $eventsService;
        $this->exchangeService = $exchangeService;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * @return CommandItemDTO[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param CommandItemDTO $command
     * @param CartOutputInterface $cartOutput
     */
    public function addItem(CommandItemDTO $command, CartOutputInterface $cartOutput): void
    {
        if (!isset($this->items[$command->getId()])) {
            $this->items[$command->getId()] = $command;
        } else {
            /** @var CommandItemDTO $item */
            $item = $this->items[$command->getId()];
            $item->setQuantity($item->getQuantity() + $command->getQuantity());
        }
        $this->eventsService->fireEvent(
            'CartAddItem',
            [
                $command,
                $this,
                $cartOutput,
            ]
        );
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        $total = 0.0;
        /** @var CommandItemDTO $item */
        foreach ($this->items as $item) {
            $amount = $item->getQuantity() * $item->getPrice();
            $converted = $this->exchangeService->convert($item->getCurrency(), $this->defaultCurrency, $amount);
            $total += $converted;
        }

        return $total;
    }

    /**
     * @return string
     */
    public function getDefaultCurrency(): string
    {
        return $this->defaultCurrency;
    }
}
