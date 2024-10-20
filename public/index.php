<?php

require_once __DIR__ . "/../vendor/autoload.php";

readEnv();

if (isset($argv[0])) {
    require_once __DIR__ . "/../routes/console.php";
} elseif (isset($_SERVER['REQUEST_URI'])) {
    require_once __DIR__ . "/../routes/web.php";
}
