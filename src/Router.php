<?php

namespace App;

class Router
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

    public function console(string $command, array $argv): void
    {
        switch ($command) {
            case 'list':
                $users = $this->repo->all();
                if (empty($users)) {
                    $this->printer->printMessage('The list is empty');
                    break;
                }

                $this->printer->printUsers($users);
                break;
            case 'create':
                if (!$this->validator->isValidForAdd($argv)) {
                    $this->printer->printMessage('Enter all the data: firstname, lastname, email');
                    break;
                }

                $user = new User($argv[2], $argv[3], $argv[4]);
                $this->repo->add($user);
                $this->printer->printMessage('User successfully added');
                break;
            case 'delete':
                if (!$this->validator->isValidForDelete($argv)) {
                    $this->printer->printMessage('Enter the user ID to delete');
                    break;
                }

                $id = $argv[2];
                if (empty($this->repo->find($id))) {
                    $this->printer->printMessage('There is no user with this id');
                    break;
                }

                $this->repo->delete($id);
                $this->printer->printMessage('User successfully deleted');
                break;
            default:
                $this->printer->printMessage('Undefined Command');
                break;
        }
    }

    public function web(string $uri, string $request, string $method): void
    {
        if ($request === 'list-users' && $method === 'GET') {
            $users = $this->repo->all();
            header('Status: 200 OK');
            header('Content-Type: application/json');
            if (empty($users)) {
                $this->printer->printMessage(json_encode('The list is empty'));
            } else {
                $this->printer->printUsersInJSON($users);
            }
        } elseif ($request === 'create-user' && $method === 'POST') {
            // getting data from the POST
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            if (!$this->validator->isValidForAdd($data)) {
                header('Status: 400 Bad Request', true, 400);
                return;
            }

            $user = new User($data['firstname'], $data['lastname'], $data['email']);
            $this->repo->add($user);
            header('Status: 200 OK', true, 201);
        } elseif ($request === 'delete-user' && $method === 'DELETE') {
            $id = explode('/', ($uri))[1] ?? null;
            if (empty($this->repo->find($id))) {
                header('Status: 400 Bad Request', true, 400);
                return;
            }

            $this->repo->delete($id);
            header('Status: 200 OK');
        } else {
            header('Status: 404 Not Found', true, 404);
        }
    }
}