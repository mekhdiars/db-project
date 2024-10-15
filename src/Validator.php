<?php

require_once __DIR__ . "/Console.php";

class Validator
{
    public function isValidForAdd($data)
    {
        // checking the existence of firstname, lastname, email
        if (!isset($data[2], $data[3], $data[4])) {
            return false;
        }

        return true;
    }

    public function isValidForDelete($data)
    {

        if (!array_key_exists(2, $data)) {
            return false;
        }

        return true;
    }
}