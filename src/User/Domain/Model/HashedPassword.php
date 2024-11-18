<?php

namespace User\Domain\Model;

final readonly class HashedPassword
{
    public function __construct(private string $hashedPassword)
    {
    }

    public function getValue(): string
    {
        return $this->hashedPassword;
    }
}
