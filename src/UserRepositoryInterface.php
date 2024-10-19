<?php

namespace App;

interface UserRepositoryInterface
{
    public function all();
    public function add(User $user);
    public function delete(int $id);
    public function find(int $id);
}