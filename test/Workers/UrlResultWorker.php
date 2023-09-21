<?php

namespace Workers;

use Services\DB\ClickhouseClient;
use Services\DB\MariadbClient;

class UrlResultWorker implements WorkerInterface
{
    public function handle(array $params): void
    {
        $clickhouse = new ClickhouseClient();
        $clickhouse->insert('content_info', $params);

        $mariadb = new MariadbClient();
        $urlExist = $mariadb->select('SELECT id FROM content_info WHERE url=:param1 LIMIT 1', [':param1' => $params['url']]);

        if (!$urlExist) {
            $mariadb->insert('content_info', $params);
        }
    }
}