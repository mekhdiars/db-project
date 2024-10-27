<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Printer;
use App\User\UserRepositoryMySQL;
use App\User\UserRepositoryJSON;
use App\User\UserControllerHTTP;
use App\User\UserControllerConsole;
use App\Router;
use App\Validator;

App\EnvReader::read(realpath(__DIR__ . "/../.env"));
$validator = new Validator();
$printer = new Printer();

if (getenv('DB_SOURCE') === 'mysql') {
    $repo = new UserRepositoryMySQL(getenv('DB_HOST'), getenv('DB_PORT'),
        getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    $userController = new UserControllerHTTP($repo, $validator, $printer);
} else {
    $repo = new UserRepositoryJSON(realpath(__DIR__ . "/../database/users.json"));
    $userController = new UserControllerConsole($repo, $validator, $printer);
}

$router = new Router($userController);

if (isset($argv[0])) {
    $command = $argv[1] ?? null;
    $router->console($command, $argv);
} elseif (isset($_SERVER['REQUEST_URI'])) {
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $request = explode('/', $uri)[0];
    $method = $_SERVER['REQUEST_METHOD'];
    $router->web($uri, $request, $method);
}
