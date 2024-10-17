<?php

namespace App;

//require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/UserRepositoryInterface.php";

use UserRepositoryInterface;

class UserRepositoryJSON implements UserRepositoryInterface
{
    private $filepath;

    public function __construct()
    {
        $this->filepath = __DIR__ . "/../database/users.json";
    }
    public function all()
    {
        $data = file_get_contents($this->filepath);
        return json_decode($data, true) ?? [];
    }

    public function add($user)
    {
        $users = $this->all();
        $lastUser = empty($users)
            ? []
            : $users[array_key_last($users)];
        $id = ($lastUser['id'] ?? 0) + 1;
        $users[$id - 1] = [
            'id' => $id,
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
        ];
        $this->save($users);
    }

    public function delete($id)
    {
        $users = $this->all();
        unset($users[$id - 1]);
        $this->save($users);
    }

    public function save($users)
    {
        file_put_contents($this->filepath, json_encode($users, JSON_PRETTY_PRINT));
    }

    public function find($id)
    {
        $users = $this->all();
        return $users[$id - 1] ?? [];
    }
}
