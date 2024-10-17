<?php

namespace App;

class User
{
    private $firstname;
    private $lastname;
    private $email;

    public function setDataFromConsole($data)
    {
        $this->firstname = $data[2];
        $this->lastname = $data[3];
        $this->email = $data[4];
    }

    public function setDataFromWeb($data)
    {
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }
}