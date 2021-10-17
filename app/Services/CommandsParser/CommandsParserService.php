<?php

namespace Shopapp\Services\CommandsParser;

use Exception;
use Shopapp\DTO\CommandItemDTO;

class CommandsParserService
{
    /**
     * @param string $inputFile
     * @return CommandItemDTO[]
     * @throws Exception
     */
    public function parse(string $inputFile): array
    {
        $contents = file_get_contents($inputFile);
        $lines = explode("\n", str_replace("\r", '', $contents));

        return $this->getCommandItemsArray($lines);
    }

    /**
     * @param array $lines
     * @return CommandItemDTO[]
     * @throws Exception
     */
    private function getCommandItemsArray(array $lines): array
    {
        $items = [];
        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }
            $explodedLine = explode(';', $line);
            $items[] = new CommandItemDTO($explodedLine);
        }

        return $items;
    }
}
