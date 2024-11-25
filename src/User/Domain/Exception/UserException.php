<?php

namespace User\Domain\Exception;

class UserException extends \Exception
{
    private function __construct(string $message = '', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
