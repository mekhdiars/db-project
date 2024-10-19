<?php

use App\Printer;
use App\User;

$command = $argv[1] ?? null;

switch ($command) {
    case 'list':
        $users = $repo->all();
        if (empty($users)) {
            Printer::printMessage('The list is empty');
            break;
        }

        Printer::printUsers($users);
        break;
    case 'create':
        if (!$validator->isValidForAdd($argv)) {
            Printer::printMessage('Enter all the data: firstname, lastname, email');
            break;
        }

        $user = new User($argv[2], $argv[3], $argv[4]);
        $repo->add($user);
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

        $repo->delete($id);
        Printer::printMessage('User successfully deleted');
        break;
    default:
        Printer::printMessage('Undefined Command');
        break;
}
