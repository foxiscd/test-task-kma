while ! clickhouse-client --host localhost --user "${CLICKHOUSE_USER}" --password "${CLICKHOUSE_PASSWORD}" -q "SHOW DATABASES"; do
  echo "waiting for ClickHouse to be up"
  sleep 1
done

clickhouse-client --host localhost --user "${CLICKHOUSE_USER}" --password "${CLICKHOUSE_PASSWORD}" --query "CREATE DATABASE IF NOT EXISTS test"
clickhouse-client --host localhost --user "${CLICKHOUSE_USER}" --password "${CLICKHOUSE_PASSWORD}" --query "$(cat /var/clickhouse/init.sql)"

tail -f /dev/null