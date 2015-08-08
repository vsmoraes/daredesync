<?php

define('APP_START', microtime(true));
define('APP_ROOT', __DIR__ . '/../');

require __DIR__ . '/../vendor/autoload.php';

$compiledPath = __DIR__ . '/cache/compiled.php';
if (file_exists($compiledPath)) {
    require $compiledPath;
}
