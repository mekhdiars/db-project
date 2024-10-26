<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\User\UserRepositoryMySQL;
use App\User\UserRepositoryJSON;
use App\User\UserControllerHTTP;
use App\User\UserControllerConsole;

App\EnvReader::read(realpath(__DIR__ . "/../.env"));
$validator = new App\Validator();
$printer = new App\Printer();

if (getenv('DB_SOURCE') === 'json') {
    $repo = new UserRepositoryJSON(realpath(__DIR__ . "/../database/users.json"));
    $userController = new UserControllerConsole($repo, $validator, $printer);
} else {
    $repo = new UserRepositoryMySQL(getenv('DB_HOST'), getenv('DB_PORT'),
        getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    $userController = new UserControllerHTTP($repo, $validator, $printer);
}

$router = new App\Router($userController);

if (isset($argv[0])) {
    $command = $argv[1] ?? null;
    $router->console($command, $argv);
} elseif (isset($_SERVER['REQUEST_URI'])) {
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $request = explode('/', $uri)[0];
    $method = $_SERVER['REQUEST_METHOD'];
    $router->web($uri, $request, $method);
}
