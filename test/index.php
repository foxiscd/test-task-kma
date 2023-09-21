<?php

use Services\QueueService\QueueService;
use Dotenv\Dotenv;

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/' . $className . '.php';
});

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';

try {
    Dotenv::createImmutable(__DIR__)->load();

    if (!empty($argv[1]) && $argv[1] === 'queue:work' && !empty($argv[2])) {
        (new QueueService())->work($argv[2]);
    }

    $controller = new \Controllers\MainController();

    if ($_SERVER['REQUEST_URI'] === '/') {
        $controller->index();
    }

    if ($_SERVER['REQUEST_URI'] === '/start'){
        $controller->start();
    }

} catch (Exception $exception) {
    exit($exception->getMessage());
}
