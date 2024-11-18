<?php

namespace Shared\Domain\Exception;

class DomainModelException extends \Exception
{
    private function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function becauseUnexpectedErrorOccurred(string $message): self
    {
        return new self($message);
    }

    public static function becauseInvalidData(string $message = '', int $code = 422, ?\Throwable $previous = null): self
    {
        return new self($message, $code, $previous);
    }
}
