<?php

namespace User\Application\Command\UserCreated;

use JetBrains\PhpStorm\ArrayShape;
use Shared\Application\Command\CommandInterface;

final readonly class UserCreatedCommand implements CommandInterface
{
    public function __construct(
        private ?string $id,
        private string $name,
        private string $lastname,
        private string $username,
        private string $email,
        private string $password,
        private bool $active,
    ) {
    }

    public function getId(): ?string
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
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return array<string, mixed>
     */
    #[ArrayShape(['id' => 'string|null', 'name' => 'string', 'lastname' => 'string', 'username' => 'string', 'email' => 'string', 'password' => 'string', 'active' => 'bool'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'active' => $this->active,
        ];
    }
}
