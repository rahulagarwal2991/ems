<?php

namespace App\Exceptions;

use Exception;

class AttendeeOperationException extends Exception
{
    protected $message = 'Attendee operation failed.';
}
