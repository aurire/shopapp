<?php

namespace Shopapp\Services\DataService;

class DataService
{
    public function getDataDirectory()
    {
        return dirname(__DIR__, 3) . '/data/';
    }
}
