<?php

use PHPFramework\Application;
use Whoops\Handler\CallbackHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$startFramework = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require_once __DIR__ . '/../config/config.php';
require_once ROOT . '/vendor/autoload.php';
require_once HELPERS . '/helpers.php';

$whoops = new Run();
if (DEBUG) {
    $whoops->pushHandler(new PrettyPageHandler());
} else {
    $whoops->pushHandler(new CallbackHandler(function (Throwable $e) {
        error_log("[" . date('Y-m-d H:i:s') . "] Error: {$e->getMessage()}" . PHP_EOL . "File: {$e->getFile()}" . PHP_EOL . "Line: {$e->getLine()}" . PHP_EOL . '================' . PHP_EOL,
            3, ERROR_LOGS);
        abort('Some error', 500);
    }));
}
$whoops->register();

$app = new Application();
require_once CONFIG . '/routes.php';

$app->run();

