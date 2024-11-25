<?php

declare(strict_types=1);

namespace User\Domain\Model;

use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Model\AbstractEntityId;
use Shared\Domain\Model\Email;

final class User extends AbstractEntity
{
    /** @var UserId */
    protected AbstractEntityId $id;

    /**
     * @param UserId $id
     */
    public function __construct(
        AbstractEntityId $id,
        private string $name,
        private string $lastname,
        private Username $username,
        private Email $email,
        private bool $isActive,
        private HashedPassword $password,
    ) {
        parent::__construct($id);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getUsername(): string
    {
        return $this->username->getValue();
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getPassword(): string
    {
        return $this->password->getValue();
    }
}
