<?php

use App\Printer;
use App\User;

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$request = explode('/', $uri)[0];
$method = $_SERVER['REQUEST_METHOD'];
$validator = new App\Validator();
$repo = getenv('DB_SOURCE') === 'json'
    ? new App\UserRepositoryJSON("/../database/users.json")
    : new App\UserRepositoryMySQL(getenv('DB_HOST'), getenv('DB_PORT'),
        getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

if ($request === 'list-users' && $method === 'GET') {
    $users = $repo->all();
    header('Status: 200 OK');
    header('Content-Type: application/json');
    if (empty($users)) {
        Printer::printMessage(json_encode('The list is empty'));
    } else {
    Printer::printUsersInJSON($users);
    }
} elseif ($request === 'create-user' && $method === 'POST') {
    // getting data from the POST
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (!$validator->isValidForAdd($data)) {
        header('Status: 400 Bad Request', true, 400);
        return;
    }

    $user = new User($data['firstname'], $data['lastname'], $data['email']);
    $repo->add($user);
    header('Status: 200 OK', true, 201);
} elseif ($request === 'delete-user' && $method === 'DELETE') {
    $id = explode('/', ($uri))[1] ?? null;
    if (empty($repo->find($id))) {
        header('Status: 400 Bad Request', true, 400);
        return;
    }

    $repo->delete($id);
    header('Status: 200 OK');
} else {
    header('Status: 404 Not Found', true, 404);
}
