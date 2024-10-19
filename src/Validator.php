<?php

namespace App;

class Validator
{
    public function isValidForAdd(array $data): bool
    {
        // checking the existence of firstname, lastname, email
        if (isset($data[2], $data[3], $data[4])
            || isset($data['firstname'], $data['lastname'], $data['email'])) {
            return true;
        }

        return false;
    }

    public function isValidForDelete(array $data): bool
    {
        // checking the existence of ID
        if (array_key_exists(2, $data)) {
            return true;
        }

        return false;
    }
}