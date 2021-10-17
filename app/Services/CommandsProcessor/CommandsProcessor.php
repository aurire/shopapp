<?php

namespace Shopapp\Services\CommandsProcessor;

use Shopapp\DTO\CommandItemDTO;
use Shopapp\Model\Cart;
use Shopapp\Services\OutputService\CartOutputInterface;

class CommandsProcessor
{
    private CartOutputInterface $cartOutput;

    public function __construct(CartOutputInterface $cartOutput)
    {
        $this->cartOutput = $cartOutput;
    }

    public function process(Cart $cart, array $commands)
    {
        /** @var CommandItemDTO $command */
        foreach ($commands as $command) {
            $cart->addItem($command, $this->cartOutput);
        }
    }
}
