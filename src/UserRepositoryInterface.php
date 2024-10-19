<?php

namespace App;

interface UserRepositoryInterface
{
    public function all();
    public function add($user);
    public function delete($id);
    public function find($id);
}