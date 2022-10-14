<?php

require_once __DIR__ . "/../vendor/autoload.php";

use FLDSoftware\Jegyzet\Bootstrap;

$env = getenv("JEGYZET_ENVIRONMENT");
if (!$env) {
    $env = Bootstrap::DEFAULT_ENVIRONMENT;
}

$app = Bootstrap::setup($env);

try {
    $app->handleRequest(
        $_SERVER
    );
} catch (Exception $ex) {
    $app->handleError($ex);
}
