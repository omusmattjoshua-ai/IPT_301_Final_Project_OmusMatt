<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;

abstract class Controller
{
    protected function isForeignKeyConstraintViolation(QueryException $exception): bool
    {
        $message = strtolower($exception->getMessage());

        return str_contains($message, 'foreign key constraint')
            || str_contains($message, 'violates foreign key')
            || str_contains($message, 'foreign key violation');
    }
}
