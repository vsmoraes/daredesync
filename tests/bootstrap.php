<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Load all constants...
 */
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

/**
 * Start application
 */
$app = \Sync\App::start(
    new \Lscms\IoC\IoC(),
    new Symfony\Component\Console\Application(),
    new \Illuminate\Database\Capsule\Manager()
);
