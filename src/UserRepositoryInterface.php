<?php


interface UserRepositoryInterface
{
    public function all();
    public function add($data);
    public function delete($data);
    public function find($id);
}