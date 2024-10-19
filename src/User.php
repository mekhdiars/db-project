<?php

namespace App;

class User
{
    private string $firstname;
    private string $lastname;
    private string $email;

    public function setDataFromConsole(array $data): void
    {
        $this->firstname = $data[2];
        $this->lastname = $data[3];
        $this->email = $data[4];
    }

    public function setDataFromWeb(array $data): void
    {
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}