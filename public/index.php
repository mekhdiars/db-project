<?php

require_once __DIR__ . "/../vendor/autoload.php";

readEnv();

$validator = new App\Validator();
$printer = new App\Printer();
$repo = getenv('DB_SOURCE') === 'json'
    ? new App\UserRepositoryJSON("/../database/users.json")
    : new App\UserRepositoryMySQL(getenv('DB_HOST'), getenv('DB_PORT'),
        getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

$router = new App\Router($repo, $validator, $printer);

if (isset($argv[0])) {
    $command = $argv[1] ?? null;
    $router->console($command, $argv);
} elseif (isset($_SERVER['REQUEST_URI'])) {
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $request = explode('/', $uri)[0];
    $method = $_SERVER['REQUEST_METHOD'];
    $router->web($uri, $request, $method);
}
