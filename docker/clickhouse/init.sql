CREATE TABLE IF NOT EXISTS test.content_info
(
    created_at DateTime,
    url String,
    length Nullable(Int32)
) ENGINE = MergeTree()
 ORDER BY created_at;