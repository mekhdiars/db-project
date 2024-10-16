<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Validator;
use App\Printer;
use App\UserRepositoryJSON;

$repo = new UserRepositoryJSON();
$validator = new Validator();
$command = $argv[1];

switch ($command) {
    case 'list':
        $users = $repo->all();
        Printer::printUsers($users);
        break;
    case 'create':
        if (!$validator->isValidForAdd($argv)) {
            Printer::printMessage('Enter all the data: firstname, lastname, email');
            break;
        }

        $repo->create($argv);
        Printer::printMessage('User successfully added');
        break;
    case 'delete':
        if (!$validator->isValidForDelete($argv)) {
            Printer::printMessage('Enter the user ID to delete');
            break;
        }

        $id = $argv[2];
        if (empty($repo->find($id))) {
            Printer::printMessage('There is no user with this id');
            break;
        }

        $repo->delete($argv);
        Printer::printMessage('User successfully deleted');
        break;
    default:
        Printer::printMessage('Undefined Command');
        break;
}
