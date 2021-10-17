<?php

namespace Shopapp\Services\OutputService;

use Shopapp\DTO\CommandItemDTO;
use Shopapp\Model\Cart;

class WebOutputService implements CartOutputInterface
{
    /**
     * @param Cart $cart
     */
    public function outputCart(Cart $cart): void
    {
        echo '<p>------------------</p>';
        $this->outputCartItems($cart->getItems());
        echo '<p>&nbsp;</p><p>Total amount in ' . $cart->getDefaultCurrency() . ': ' . $cart->getTotalAmount() . '</p>';
        echo '<p>------------------</p><p>&nbsp;</p>';
    }

    /**
     * @param array $items
     */
    public function outputCartItems(array $items): void
    {
        echo '<p>Cart items:</p>';
        echo '<p>&nbsp;</p>';
        foreach ($items as $item) {
            $this->outputCartItem($item);
        }
    }

    /**
     * @param CommandItemDTO $item
     */
    public function outputCartItem(CommandItemDTO $item): void
    {
        echo '<p>' . $item->getName() . ' (' . $item->getId() . ') ' . $item->getQuantity() .  ' x '
            . $item->getPrice() . ' ' . $item->getCurrency() . '</p>';
    }
}
