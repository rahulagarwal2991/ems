<?php

namespace App\Exceptions;

use Exception;

class EventOperationException extends Exception
{
    protected $message = 'Failed to process event operation.';
}
