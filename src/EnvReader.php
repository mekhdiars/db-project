<?php

namespace App;

class EnvReader
{
    public static function read(string $path): void
    {
        if (!file_exists($path)) {
            $printer = new Printer();
            $printer->printMessage("File .env not found");
            return;
        }

        $environments = file_get_contents($path);
        $lines = explode("\n", $environments);
        foreach ($lines as $line) {
            if ($line[0] === '#') {
                continue;
            }

            [$key, $value] = explode('=', $line);
            putenv("{$key}={$value}");
        }
    }
}