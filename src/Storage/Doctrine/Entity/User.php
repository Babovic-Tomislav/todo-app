<?php

namespace Storage\Doctrine\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Shared\Domain\Model\StorageEntityInterface;
use Storage\Doctrine\Entity\Traits\SoftDeletableEntityTrait;
use Storage\Doctrine\Entity\Traits\TimestampableEntityTrait;
use Storage\Doctrine\Entity\Traits\UuidPrimaryKeyEntityTrait;
use Storage\Doctrine\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements StorageEntityInterface
{
    use SoftDeletableEntityTrait;
    use TimestampableEntityTrait;
    use UuidPrimaryKeyEntityTrait;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $lastname;

    #[ORM\Column(length: 20)]
    private string $username;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(length: 64)]
    private string $password;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $active;

    public function __construct(
        ?string $id,
    ) {
        if (null === $id) {
            $id = Uuid::uuid4()->toString();
        }

        $this->id = $id;
        $this->active = false;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
