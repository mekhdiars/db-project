<?php

namespace App;

class Printer
{
    public static function printUsers(array $users): void
    {
        echo 'List of users:' . PHP_EOL;
        foreach ($users as $user) {
            echo "- ID: {$user['id']}, {$user['firstname']} {$user['lastname']}, {$user['email']}\n";
        }
    }

    public static function printUsersInJSON(string $data): void
    {
        print_r(json_encode($data));
    }

    public static function printMessage(string $messages): void
    {
        echo $messages . PHP_EOL;
    }
}
