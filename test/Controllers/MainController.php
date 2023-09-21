<?php

namespace Controllers;

use Services\DB\ClickhouseClient;
use Workers\UrlAnaliseWorker;

class MainController extends AbstractController
{
    /**
     * @return void
     * @throws \Exception
     */
    public function index()
    {
        $query = "SELECT toStartOfMinute(created_at) AS minute,
                           count() AS row_count,
                           avg(length) AS avg_length,
                           min(created_at) AS first_message_time,
                           max(created_at) AS last_message_time
                    FROM content_info
                    GROUP BY minute
                    ORDER BY minute";

        $service = new ClickhouseClient();

        $statistic = $service->select($query, [
            'minute', 'row_count', 'avg_length', 'first_message_time', 'last_message_time'
        ]);

        $this->view->renderHtml('index.php', compact('statistic'));
    }

    /**
     * @return void
     */
    public function start()
    {
        $urls = include './../urls.php';

        dispatch('url', new UrlAnaliseWorker(), $urls);

        header("Location: " . "http://localhost");
    }
}