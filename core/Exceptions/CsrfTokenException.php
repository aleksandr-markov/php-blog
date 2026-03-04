<?php

namespace PHPFramework\Exceptions;

use Exception;

class CsrfTokenException extends Exception
{
    protected $message = 'CSRF token validation failed';
    protected $code = 419;
}