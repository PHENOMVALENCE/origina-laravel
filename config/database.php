<?php

return [
    'default' => env('DB_CONNECTION', 'sqlite'),
    'connections' => [
        'sqlite' => ['driver' => 'sqlite', 'url' => env('DB_URL'), 'database' => env('DB_DATABASE', database_path('database.sqlite')), 'prefix' => '', 'foreign_key_constraints' => true, 'busy_timeout' => 5000, 'journal_mode' => 'WAL', 'synchronous' => 'NORMAL'],
        'mysql' => ['driver' => 'mysql', 'url' => env('DB_URL'), 'host' => env('DB_HOST', '127.0.0.1'), 'port' => env('DB_PORT', '3306'), 'database' => env('DB_DATABASE', 'origina'), 'username' => env('DB_USERNAME', 'origina'), 'password' => env('DB_PASSWORD', ''), 'unix_socket' => env('DB_SOCKET', ''), 'charset' => 'utf8mb4', 'collation' => 'utf8mb4_unicode_ci', 'prefix' => '', 'prefix_indexes' => true, 'strict' => true, 'engine' => null],
    ],
    'migrations' => ['table' => 'migrations', 'update_date_on_publish' => true],
];
