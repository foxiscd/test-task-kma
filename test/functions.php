<?php

use Workers\WorkerInterface;
use Services\QueueService\QueueService;

/**
 * @param string $configName
 * @return mixed
 */
function config(string $configName): mixed
{
    $path = __DIR__ . '/Config/' . $configName . '.php';
    return include $path;
}

/**
 * @param string $queueName
 * @param WorkerInterface $worker
 * @param array $params
 * @return void
 * @throws Exception
 */
function dispatch(string $queueName, WorkerInterface $worker, array $params = []): void
{
    $service = new QueueService();
    $service->dispatch($queueName, $worker, $params);
}