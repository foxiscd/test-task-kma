<?php

return [
    'db' => [
        'clickhouse' => [
            'host' => $_ENV['CLICKHOUSE_DB_HOST'],
            'port' => $_ENV['CLICKHOUSE_PORT'],
            'user' => $_ENV['CLICKHOUSE_USER'],
            'password' => $_ENV['CLICKHOUSE_PASSWORD'],
            'database' => $_ENV['CLICKHOUSE_DB_NAME'],
        ],
        'mariadb' => [
            'host' => $_ENV['MARIADB_DB_HOST'],
            'port' => $_ENV['MARIADB_PORT'],
            'user' => $_ENV['MARIADB_USER'],
            'password' => $_ENV['MARIADB_PASSWORD'],
            'database' => $_ENV['MARIADB_DB_NAME'],
        ],
    ],
    'queue' => [
        'queues' => ['url', 'url_result'],
        'rabbitmq' => [
            'host' => $_ENV['RABBITMQ_HOST'],
            'port' => $_ENV['RABBITMQ_PORT'],
            'user' => $_ENV['RABBITMQ_USER'],
            'password' => $_ENV['RABBITMQ_PASSWORD'],
        ]
    ]
];