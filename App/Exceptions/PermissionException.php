<?php

namespace App\Exceptions;

use Exception;

class PermissionException extends Exception
{
    protected $message = 'no permission to save the file';
}
