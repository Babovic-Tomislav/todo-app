<?php

namespace Auth\Domain\Model;

use Shared\Domain\Model\Email;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Domain\Model\HashedPassword;
use User\Domain\Model\UserId;
use User\Domain\Model\Username;

final readonly class AuthUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private UserId $id,
        private Email $email,
        private HashedPassword $password,
        private Username $username,
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

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}
