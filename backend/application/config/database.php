<?php
/**
 * PDO uchun massivdagi ishlatiladigan baza nomini ko'rsating
 * postgres va sqlite sinab ko'rilgan!
 **/

define('SHAFTOLI_DB', 'postgresql');


return [

    'mysql' => [
        'mysql:host=localhost',
        'port=3306',
        'dbname=basename',
        'charset=utf8',
        'user' => 'username',
        'pass' => 'password'
    ],

    'sqlite' => [
        'sqlite:application/config/main.db',
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



