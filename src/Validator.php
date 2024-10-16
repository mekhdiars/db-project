<?php

namespace App;

class Validator
{
    public function isValidForAdd($data)
    {
        // checking the existence of firstname, lastname, email
        if (!isset($data[2], $data[3], $data[4])
            && !isset($data['firstname'], $data['lastname'], $data['email'])) {
            return false;
        }

        return true;
    }

    public function isValidForDelete($data)
    {
        // checking the existence of ID
        if (!array_key_exists(2, $data)) {
            return false;
        }

        return true;
    }
}