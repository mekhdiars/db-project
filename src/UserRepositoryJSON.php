<?php

namespace App;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/UserRepositoryInterface.php";

class UserRepositoryJSON implements UserRepositoryInterface
{
    private string $filepath;

    public function __construct()
    {
        $this->filepath = __DIR__ . "/../database/users.json";
    }
    public function all(): array
    {
        $data = file_get_contents($this->filepath);
        return json_decode($data, true);
    }

    public function add(User $user): void
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

    public function delete(int $id)
    {
        $users = $this->all();
        unset($users[$id - 1]);
        $this->save($users);
    }

    public function save($users)
    {
        file_put_contents($this->filepath, json_encode($users, JSON_PRETTY_PRINT));
    }

    public function find(int $id)
    {
        $users = $this->all();
        return $users[$id - 1] ?? [];
    }
}
