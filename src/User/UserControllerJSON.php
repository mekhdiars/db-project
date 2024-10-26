<?php

namespace App\User;

use App\Validator;
use App\Printer;

class UserControllerJSON implements UserControllerInterface
{
    private UserRepositoryInterface $repo;
    private Validator $validator;
    private Printer $printer;

    public function __construct(UserRepositoryInterface $repo, Validator $validator, Printer $printer)
    {
        $this->repo = $repo;
        $this->validator = $validator;
        $this->printer = $printer;
    }

    public function list(): void
    {
        $users = $this->repo->all();
        if (empty($users)) {
            $this->printer->printMessage('The list is empty');
            return;
        }

        $this->printer->printUsers($users);
    }

    public function create(array $data): void
    {
        if (!$this->validator->isValidForAdd($data)) {
            $this->printer->printMessage('Enter all the data: firstname, lastname, email');
            return;
        }

        $user = new User($data[2], $data[3], $data[4]);
        $this->repo->add($user);
        $this->printer->printMessage('User successfully added');
    }

    public function delete(int $id): void
    {
        if (empty($this->repo->find($id))) {
            $this->printer->printMessage('There is no user with this id');
            return;
        }

        $this->repo->delete($id);
        $this->printer->printMessage('User successfully deleted');
    }

    public function unknown(): void
    {
        $this->printer->printMessage('Unknown command');
    }
}
