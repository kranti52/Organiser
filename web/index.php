<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->boot();
$app->run();
