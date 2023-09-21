ARG CLICKHOUSE_VERSION
ARG CLICKHOUSE_USER
ARG CLICKHOUSE_PASSWORD

FROM yandex/clickhouse-server:${CLICKHOUSE_VERSION}

COPY entrypoint.sh  /docker-entrypoint-initdb.d/init-defaults.sh
COPY users.xml /etc/clickhouse-server/users.xml
COPY init.sql  /var/clickhouse/init.sql
