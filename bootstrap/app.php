<?php

use GuzzleHttp\Client;
use Sync\Pipedrive\Request as RequestInterface;
use Sync\Pipedrive\Guzzle\Request;

require __DIR__ . '/bootstrap.php';

$dotenv = new \Dotenv\Dotenv(APP_ROOT);
$dotenv->load();

$app = \Sync\App::start(
    new \Lscms\IoC\IoC(),
    new Symfony\Component\Console\Application()
);

$app->bind(RequestInterface::class, Request::class);
$app->bind(Client::class, new Client([]));

return $app;
