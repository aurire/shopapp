<?php

namespace Shopapp\Services\OutputService;

use Shopapp\DTO\CommandItemDTO;
use Shopapp\Model\Cart;

interface CartOutputInterface
{
    /**
     * @param Cart $cart
     */
    public function outputCart(Cart $cart): void;

    /**
     * @param array $items
     */
    public function outputCartItems(array $items): void;

    /**
     * @param CommandItemDTO $item
     */
    public function outputCartItem(CommandItemDTO $item): void;
}
