<?php

function readEnv($path = '.env')
{
    $environments = file_get_contents(__DIR__ . "/{$path}");
    $lines = explode("\n", $environments);
    foreach ($lines as $line) {
        if ($line[0] === '#') {
            continue;
        }

        [$key, $value] = explode('=', $line);
        putenv("{$key}={$value}");
    }
}
