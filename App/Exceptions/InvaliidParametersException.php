<?php

namespace App\Exceptions;

use Exception;

class InvaliidParametersException extends Exception
{
    protected $message = 'Invalid parameter';
}
