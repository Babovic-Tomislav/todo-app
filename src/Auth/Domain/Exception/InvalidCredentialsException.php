<?php

namespace Auth\Domain\Exception;

class InvalidCredentialsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid email or password');
    }
}
