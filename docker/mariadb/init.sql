USE test;

CREATE TABLE IF NOT EXISTS content_info
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    url        VARCHAR(500) NOT NULL UNIQUE,
    length     INT,
    created_at TIMESTAMP NOT NULL
);