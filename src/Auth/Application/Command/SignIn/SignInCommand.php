<?php

namespace Auth\Application\Command\SignIn;

use Shared\Application\Command\CommandInterface;

final readonly class SignInCommand implements CommandInterface
{
    public function __construct(
        private string $email,
        private string $password,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
