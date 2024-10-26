<?php

namespace App;

use App\User\UserControllerInterface;

class Router
{
    private UserControllerInterface $userController;

    public function __construct(UserControllerInterface $userController)
    {
        $this->userController = $userController;
    }

    public function console(string $command, array $data): void
    {
        switch ($command) {
            case 'list':
                $this->userController->list();
                break;
            case 'create':
                $this->userController->create($data);
                break;
            case 'delete':
                $id = $data[2] ?? null;
                $this->userController->delete($id);
                break;
            default:
                $this->userController->unknown();
                break;
        }
    }

    public function web(string $uri, string $request, string $method): void
    {
        if ($request === 'list-users' && $method === 'GET') {
            $this->userController->list();
        } elseif ($request === 'create-user' && $method === 'POST') {
            // получение данных JSON отправленных через POST-запрос
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $this->userController->create($data);
        } elseif ($request === 'delete-user' && $method === 'DELETE') {
            $id = explode('/', ($uri))[1] ?? null;
            $this->userController->delete($id);
        } else {
            $this->userController->unknown();
        }
    }
}
