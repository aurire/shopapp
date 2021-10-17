<?php

use Shopapp\Base\Shopapp;
use Shopapp\Services\OutputService\WebOutputService;

require __DIR__.'/../vendor/autoload.php';

$shopApp = new Shopapp(new WebOutputService());
$shopApp->run();
