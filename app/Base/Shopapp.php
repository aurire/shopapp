<?php

namespace Shopapp\Base;

use Exception;
use Shopapp\DTO\CommandItemDTO;
use Shopapp\EventListeners\CartAddItem\OutputDetailsOnCartAdd;
use Shopapp\Model\Cart;
use Shopapp\Services\CommandsParser\CommandsParserService;
use Shopapp\Services\CommandsProcessor\CommandsProcessor;
use Shopapp\Services\DataService\DataService;
use Shopapp\Services\EventsService\EventsService;
use Shopapp\Services\ExchangeService\ExchangeService;
use Shopapp\Services\OutputService\CartOutputInterface;

class Shopapp
{
    /**
     * @var string
     */
    public const INPUT_DATA_FILE = 'inputdata.txt';

    /**
     * @var DataService $dataService
     */
    private DataService $dataService;

    /**
     * @var CommandsParserService $commandsParser
     */
    private CommandsParserService $commandsParser;

    /**
     * @var CartOutputInterface $outputService
     */
    private CartOutputInterface $outputService;

    /**
     * @var CommandsProcessor $commandsProcessor
     */
    private CommandsProcessor $commandsProcessor;

    /**
     * @var EventsService $eventsService
     */
    private EventsService $eventsService;

    /**
     * @var Cart $cart
     */
    private Cart $cart;

    /**
     * @param CartOutputInterface $outputService
     */
    public function __construct(CartOutputInterface $outputService)
    {
        $this->dataService = new DataService();
        $this->commandsParser = new CommandsParserService();
        $this->outputService = $outputService;
        $this->commandsProcessor = new CommandsProcessor($this->outputService);
        $this->eventsService = new EventsService();
        $this->exchangeService = new ExchangeService();
        $this->cart = new Cart($this->eventsService, $this->exchangeService, 'EUR');
        $this->eventsService->registerListener('CartAddItem', OutputDetailsOnCartAdd::class);
    }

    public function run()
    {
        $commands = $this->readInputData();

        $this->commandsProcessor->process($this->cart, $commands);
    }

    /**
     * @return CommandItemDTO[]
     * @throws Exception
     */
    private function readInputData(): array
    {
        $dataDirectory = $this->dataService->getDataDirectory();

        return $this->commandsParser->parse($dataDirectory . self::INPUT_DATA_FILE);
    }
}
