<?php

require_once __DIR__ . "/Console.php";
require_once __DIR__ . "/Validator.php";
require_once __DIR__ . "/../vendor/autoload.php";

class UserRepository
{
    public function all()
    {
        $data = file_get_contents(__DIR__ . "/../database/users.json");
        return json_decode($data, true) ?? [];
    }

    public function add($data)
    {
        $users = $this->all();
        $lastUser = $users[array_key_last($users)] ?? [];
        $id = ($lastUser['id'] ?? 0) + 1;
        $users[$id - 1] = [
            'id' => $id,
            'firstname' => $data[2],
            'lastname' => $data[3],
            'email' => $data[4]
        ];
        $this->save($users);
    }

    public function delete($data)
    {
        $id = $data[2];
        $users = $this->all();
        unset($users[$id - 1]);
        $this->save($users);
    }

    public function save($users)
    {
        file_put_contents(__DIR__ . "/../database/users.json", json_encode($users, JSON_PRETTY_PRINT));
    }

    public function find($id)
    {
        $users = $this->all();
        return $users[$id - 1] ?? [];
    }
}
