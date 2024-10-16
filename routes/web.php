<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Validator;
use App\Printer;
use App\UserRepositoryMySQL;

$repo = new UserRepositoryMySQL();
$validator = new Validator();
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$request = explode('/', $uri)[0];
$method = $_SERVER['REQUEST_METHOD'];

if ($request === 'list-users' && $method === 'GET') {
    $users = $repo->all();
    Printer::printUsersForWeb($users);
    header('Status: 200 OK');
} elseif ($request === 'create-user' && $method === 'POST') {
    // getting data from the POST
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (!$validator->isValidForAdd($data)) {
        header('Status: 400 Bad Request', true, 400);
    }

    $repo->create($data);
    header('Status: 200 OK', true, 201);
} elseif ($request === 'delete-user' && $method === 'DELETE') {
    $id = explode('/', ($uri))[1] ?? null;
    if (empty($repo->find($id))) {
        header('Status: 400 Bad Request', true, 400);
    }

    $repo->delete($request);
    header('Status: 200 OK');
} else {
    header('Status: 404 Not Found', true, 404);
}
