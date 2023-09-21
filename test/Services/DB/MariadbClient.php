<?php

namespace Services\DB;


class MariadbClient
{
    private $pdo;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->pdo = new \PDO(
            'mysql:host=' . $_ENV['MARIADB_DB_HOST']
            . ';dbname=' . $_ENV['MARIADB_DB_NAME'],
            $_ENV['MARIADB_USER'],
            $_ENV['MARIADB_PASSWORD']
        );
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function select(string $sql, array $params): ?array
    {
        return $this->query($sql, $params);
    }

    /**
     * @param $tableName
     * @param array $params
     * @return array|null
     */
    public function insert($tableName, array $params): ?array
    {
        $params2values = [];
        $columns = [];
        $values = [];
        $index = 1;

        foreach ($params as $column => $value) {
            $values[] = ':param' . $index;
            $columns[] = $column;
            $params2values[':param' . $index] = $value;

            $index++;
        }

        $sql = 'INSERT INTO `' . $tableName . '` (' . implode(',', $columns) . ') VALUES (' . implode(',', $values) . ');';

        return $this->query($sql, $params2values);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    private function query(string $sql, array $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_ASSOC) ?: null;
    }
}