<?php

require_once __DIR__ . "/../vendor/autoload.php";

readEnv();
$repo = getenv('DB_SOURCE') === 'json'
    ? require_once __DIR__ . "/../routes/console.php"
    : require_once __DIR__ . "/../routes/web.php";
