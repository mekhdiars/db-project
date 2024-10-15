<?php

class Console
{
    public static function printUsers($users)
    {
        if (empty($users)) {
            echo 'The list is empty';
            return;
        }

        echo 'List of users:' . PHP_EOL;
        foreach ($users as $user) {
            echo "- ID: {$user['id']}, {$user['firstname']} {$user['lastname']}, {$user['email']}\n";
        }
    }

    public static function printMessage($messages)
    {
        echo $messages . PHP_EOL;
    }
}
