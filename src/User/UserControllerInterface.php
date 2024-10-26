<?php

namespace App\User;

interface UserControllerInterface
{
    public function list(): void;
    public function create(array $data): void;
    public function delete(int $id): void;
    public function unknown(): void;
}