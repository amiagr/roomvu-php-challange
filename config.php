<?php

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'db_name' => getenv('DB_NAME') ?: 'roomvu_main',
        'test_db_name' => getenv('TEST_DB_NAME') ?: 'roomvu_test',
        'username' => getenv('DB_USERNAME') ?: '',
        'password' => getenv('DB_PASSWORD') ?: '',
    ],
];