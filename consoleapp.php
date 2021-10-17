<?php

use Shopapp\Base\Shopapp;
use Shopapp\Services\OutputService\ConsoleOutputService;

require __DIR__.'/vendor/autoload.php';

$shopApp = new Shopapp(new ConsoleOutputService());
$shopApp->run();
