<?php
namespace App\Exceptions;

use Exception;

class EventFullyBookedException extends Exception
{
    protected $message = 'Event is fully booked.';
}
