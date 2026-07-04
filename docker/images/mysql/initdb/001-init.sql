CREATE DATABASE IF NOT EXISTS laravel
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'testuser'@'%' IDENTIFIED BY 'test123';

GRANT ALL PRIVILEGES
    ON laravel.*
    TO 'testuser'@'%';

FLUSH PRIVILEGES;
