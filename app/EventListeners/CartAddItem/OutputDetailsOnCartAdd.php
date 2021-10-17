<?php

namespace Shopapp\EventListeners\CartAddItem;

use Shopapp\DTO\CommandItemDTO;
use Shopapp\Model\Cart;
use Shopapp\Services\OutputService\CartOutputInterface;

class OutputDetailsOnCartAdd
{
    /**
     * @param CommandItemDTO $command
     * @param Cart $cart
     * @param CartOutputInterface $cartOutput
     */
    public function handle(CommandItemDTO $command, Cart $cart, CartOutputInterface $cartOutput)
    {
        //gal reiktu $command aprasyti isvedimo metu, pvz pridedama x itemu arba isimama y itemu
        $cartOutput->outputCart($cart);
    }
}
