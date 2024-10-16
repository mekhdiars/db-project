<?php


interface UserRepositoryInterface
{
    public function all();
    public function create($data);
    public function delete($data);
    public function find($id);
}