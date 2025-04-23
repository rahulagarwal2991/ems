<?php

namespace App\Exceptions;

use Exception;

class AttendeeNotFoundException extends Exception
{
    protected $message = 'Attendee not found.';
}
