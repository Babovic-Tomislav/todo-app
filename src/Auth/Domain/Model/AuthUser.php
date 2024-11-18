<?php

namespace Auth\Domain\Model;

use Shared\Domain\Model\Email;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Domain\Model\HashedPassword;

final readonly class AuthUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private Email $email,
        private HashedPassword $password,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    public function getPassword(): string
    {
        return $this->password->getValue();
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }
}
