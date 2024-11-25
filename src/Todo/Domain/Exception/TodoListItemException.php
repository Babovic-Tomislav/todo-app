<?php

namespace Todo\Domain\Exception;

class TodoListItemException extends \Exception
{
    private function __construct(string $message = '', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
