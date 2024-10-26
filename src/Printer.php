<?php

namespace App;

class Printer
{
    public function printUsers(array $users): void
    {
        echo 'List of users:' . PHP_EOL;
        foreach ($users as $user) {
            echo "- ID: {$user['id']}, {$user['firstname']} {$user['lastname']}, {$user['email']}\n";
        }
    }

    public function printUsersInJSON(string|array $data): void
    {
        print_r(json_encode($data, JSON_PRETTY_PRINT));
    }

    public function printMessage(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
