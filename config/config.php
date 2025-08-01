<?php

use Dotenv\Dotenv;
use Doctrine\ORM\ORMSetup;

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(__DIR__.'/../');
$dotenv->safeLoad();

return [
    'debug' => filter_var(getenv('DEBUG'), \FILTER_VALIDATE_BOOLEAN),

    'em_conn' => 'pdo_sqlite' == getenv('DB_DRIVER') ? [
        'driver' => getenv('DB_DRIVER'),
        'path' => __DIR__.'/../database/bd.sqlite',
    ] : [
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
        'port' => getenv('DB_PORT'),
        'dbname' => getenv('DB_DATABASE'),
    ],
    'em_config' => ORMSetup::createXMLMetadataConfiguration(
        [
            __DIR__,
        ],
        true
    ),
];
