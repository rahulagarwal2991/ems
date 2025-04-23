<?php

namespace App\Exceptions;

use Exception;

class DuplicateBookingException extends Exception
{
    protected $message = 'Duplicate booking not allowed.';
}

