<?php

namespace App\Core\Exceptions;

class Handler
{
    public static function handler($exception)
    {
        if ($exception instanceof AbstractException) {
            echo $exception->throwWithMessage();
            return;
        }

        echo $exception->getMessage();
    }
}
