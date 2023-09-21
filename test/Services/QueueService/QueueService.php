<?php

namespace Services\QueueService;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Workers\WorkerInterface;

class QueueService
{
    private $connection;
    private $channel;

    public function __construct()
    {
        $config = config('app')['queue']['rabbitmq'];

        $this->connection = new AMQPStreamConnection(
            $config['host'], $config['port'], $config['user'], $config['password']
        );

        $this->channel = $this->connection->channel();
    }

    /**
     * @param string $queueName
     * @param WorkerInterface $worker
     * @param array $params
     * @return void
     * @throws \Exception
     */
    public function dispatch(string $queueName, WorkerInterface $worker, array $params): void
    {
        $this->checkQueue($queueName);

        $this->channel->queue_declare($queueName, false, true, false, false);

        $message = json_encode([
            'worker' => $worker::class,
            'params' => $params
        ]);

        $this->channel->basic_publish(new AMQPMessage($message), '', $queueName);
    }

    /**
     * @param string $queueName
     * @return void
     * @throws \Exception
     */
    public function work(string $queueName): void
    {
        $this->checkQueue($queueName);

        $this->channel->basic_consume(
            $queueName,
            '',
            false,
            true,
            false,
            false,
            function ($message) {
                $body = json_decode($message->body, true);
                (new $body['worker'])->handle($body['params']);
            }
        );

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
    }

    /**
     * @param string $queueName
     * @return void
     * @throws \Exception
     */
    private function checkQueue(string $queueName): void
    {
        if (!in_array($queueName, config('app')['queue']['queues'])) {
            throw new \Exception('Queue does not exist');
        }
    }
}