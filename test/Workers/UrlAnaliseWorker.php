<?php

namespace Workers;

class UrlAnaliseWorker implements WorkerInterface
{
    public function handle(array $params): void
    {
        foreach ($params as $url) {
            $content = file_get_contents($url);

            dispatch('url_result', new UrlResultWorker(), [
                'url' => $url,
                'length' => strlen($content),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            sleep(rand(10, 100));
        }
    }
}