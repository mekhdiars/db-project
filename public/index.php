<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/UserRepository.php";
require_once __DIR__ . "/../src/Validator.php";
require_once __DIR__ . "/../src/Console.php";

$command = $argv[1] ?? null;
$repo = new UserRepository();
$validator = new Validator();

switch ($command) {
    case 'list':
        $users = $repo->all();
        Console::printUsers($users);
        break;
    case 'add':
        if (!$validator->isValidForAdd($argv)) {
            Console::printMessage('Enter all the data: firstname, lastname, email');
            break;
        }

        $repo->add($argv);
        Console::printMessage('User successfully added');
        break;
    case 'delete':
        if (!$validator->isValidForDelete($argv)) {
            Console::printMessage('Enter the user ID to delete');
            break;
        }

        $id = $argv[2];
        if (empty($repo->find($id))) {
            Console::printMessage('There is no user with this id');
            break;
        }

        $repo->delete($argv);
        Console::printMessage('User successfully deleted');
        break;
    default:
        Console::printMessage('Undefined Command');
        break;
}
