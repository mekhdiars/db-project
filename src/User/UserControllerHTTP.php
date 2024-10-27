<?php

namespace App\User;

use App\Validator;
use App\Printer;

class UserControllerHTTP implements UserControllerInterface
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
        header('Status: 200 OK');
        header('Content-Type: application/json');
        if (empty($users)) {
            $this->printer->printMessage(json_encode('The list is empty'));
        } else {
            $this->printer->printUsersInJSON($users);
        }
    }

    public function create($data): void
    {
        if (!$this->validator->isValidForAdd($data)) {
            header('Status: 400 Bad Request', true, 400);
            return;
        }

        $user = new User($data['firstname'], $data['lastname'], $data['email']);
        $this->repo->add($user);
        header('Status: 200 OK', true, 201);
    }

    public function delete($id): void
    {
        if (empty($this->repo->find($id))) {
            header('Status: 400 Bad Request', true, 400);
            return;
        }

        $this->repo->delete($id);
        header('Status: 200 OK');
    }

    public function unknown(): void
    {
        header('Status: 404 Not Found', true, 404);
    }
}
