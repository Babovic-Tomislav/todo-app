<?php

namespace Shared\Domain\Model;

final readonly class Email
{
    public function __construct(private string $email)
    {
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
