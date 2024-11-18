<?php

namespace User\Domain\Exception;

class UserException extends \Exception
{
    private function __construct(string $message = '', int $code = 500)
    {
        parent::__construct($message, $code);
    }

    public static function becauseUserNotFound(?string $message = null): self
    {
        if (!empty($message)) {
            return new self($message);
        }

        return new self('User not found', 404);
    }
}
