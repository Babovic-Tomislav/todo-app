<?php

namespace User\Domain\Model;

final readonly class Username
{
    public function __construct(private string $username)
    {
    }

    public function getValue(): string
    {
        return $this->username;
    }
}
