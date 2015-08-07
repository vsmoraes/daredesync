<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Load all constants...
 */
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();
