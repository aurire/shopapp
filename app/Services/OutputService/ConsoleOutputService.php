<?php

namespace Shopapp\Services\OutputService;

use Shopapp\DTO\CommandItemDTO;
use Shopapp\Model\Cart;

class ConsoleOutputService implements CartOutputInterface
{
    /**
     * @param Cart $cart
     */
    public function outputCart(Cart $cart): void
    {
        echo '------------------' . "\n";
        $this->outputCartItems($cart->getItems());
        echo 'Total amount in ' . $cart->getDefaultCurrency() . ': ' . $cart->getTotalAmount() . "\n";
        echo '------------------' . "\n";
    }

    /**
     * @param array $items
     */
    public function outputCartItems(array $items): void
    {
        echo 'Cart items:' . "\n";
        echo  "\n";
        foreach ($items as $item) {
            $this->outputCartItem($item);
        }
    }

    /**
     * @param CommandItemDTO $item
     */
    public function outputCartItem(CommandItemDTO $item): void
    {
        echo $item->getName() . ' (' . $item->getId() . ') ' . $item->getQuantity() .  ' x ' . $item->getPrice() . ' '
            . $item->getCurrency() . "\n";
    }
}
