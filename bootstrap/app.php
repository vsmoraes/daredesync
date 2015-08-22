<?php

use GuzzleHttp\Client;
use Sync\Pipedrive\Request as RequestInterface;
use Sync\Pipedrive\Guzzle\Request;
use Sync\Support\Database;

require __DIR__ . '/bootstrap.php';

$dotenv = new \Dotenv\Dotenv(APP_ROOT);
$dotenv->load();

$app = \Sync\App::start(
    new \Lscms\IoC\IoC(),
    new Symfony\Component\Console\Application(),
    Database::getInstance()
);

$app->bind(RequestInterface::class, Request::class);
$app->bind(Client::class, new Client([]));
$app->bind(Database::class, Database::getInstance());

return $app;
