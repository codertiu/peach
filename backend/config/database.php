<?php


define('DBI', 'mysql'); //DB Info


return [
    'mysql' => [
        'mysql:host=localhost',
        'port=3306',
        'dbname=mvc',
        'charset=utf8',
        'user' => 'root',
        'pass' => null,
    ],

    'sqlite' => [
        'sqlite:src/file.db',
        //'user' => 'username',
        //'pass' => 'password'
    ],

    'postgresql' => [
        'pgsql:host=pgsql',
        'port=5432',
        'dbname=peach_db',
        'user' => 'peach',
        'pass' => 'secret'
    ],

    'mysql.sphinx-search' => [
        'mysql:host=127.0.0.1',
        'port=9306',
        'user' => 'username',
        'pass' => 'password'
    ],

    'redis' => [
        'scheme' => 'tcp',
        'host' => '127.0.0.1',
        'port' => '6379',
        /** 'password' => 'password' */
    ]

];