<?php

require_once __DIR__ . "/../vendor/autoload.php";

readEnv();
$validator = new App\Validator();
$repo = getenv('DB_SOURCE') === 'json'
    ? new App\UserRepositoryJSON("/../database/users.json")
    : new App\UserRepositoryMySQL(getenv('DB_HOST'), getenv('DB_PORT'),
        getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

if (isset($argv[0])) {
    require_once __DIR__ . "/../routes/console.php";
} elseif (isset($_SERVER['REQUEST_URI'])) {
    require_once __DIR__ . "/../routes/web.php";
}
