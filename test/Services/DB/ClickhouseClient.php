<?php

namespace Services\DB;

class ClickhouseClient
{
    private $url;
    private $query;
    private $auth;

    public function __construct()
    {
        $dbConfig = config('app')['db']['clickhouse'];
        $this->url = "http://{$dbConfig['host']}:{$dbConfig['port']}?database={$dbConfig['database']}";
        $this->auth = base64_encode("{$dbConfig['user']}:{$dbConfig['password']}");
    }

    /**
     * @param string $sql
     * @param array $sqlParams
     * @return null|array
     * @throws \Exception
     */
    public function select(string $sql, array $sqlParams): ?array
    {
        $this->query = $sql;

        $response = $this->execute();

        if (!$response){
            return null;
        }

        $lines = explode("\n", trim($response));
        $paramsValues = [];

        foreach ($lines as $key => $line) {
            $fields = explode("\t", $line);

            foreach ($fields as $fieldKey => $field) {
                $paramsValues[$key][$sqlParams[$fieldKey]] = $field;
            }
        }

        return $paramsValues;
    }

    /**
     * @param string $tableName
     * @param array $params
     * @return void
     * @throws \Exception
     */
    public function insert(string $tableName, array $params): void
    {
        $keys = [];
        $values = [];

        foreach ($params as $key => $value) {
            $keys[] = $key;
            $values[] = is_string($value) ? "'" . $value . "'" : $value;
        }

        $keysStr = implode(', ', $keys);
        $valuesStr = implode(', ', $values);
        $this->query = "INSERT INTO {$tableName} ({$keysStr}) VALUES ({$valuesStr})";

        $this->execute();
    }

    /**
     * @return bool|string
     * @throws \Exception
     */
    private function execute()
    {
        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: Basic $this->auth",
            'Accept: text/csv',
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception((curl_error($ch)));
        }

        curl_close($ch);

        return $response;
    }
}