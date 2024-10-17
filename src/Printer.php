<?php

namespace App;

class Printer
{
    public static function printUsers($users)
    {
        echo 'List of users:' . PHP_EOL;
        foreach ($users as $user) {
            echo "- ID: {$user['id']}, {$user['firstname']} {$user['lastname']}, {$user['email']}\n";
        }
    }

    public static function printUsersForWeb($data)
    {
        print_r($data);
    }

    public static function printMessage($messages)
    {
        echo $messages . PHP_EOL;
    }
}
