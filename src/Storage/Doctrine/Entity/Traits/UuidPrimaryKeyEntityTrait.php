<?php

declare(strict_types=1);

namespace Storage\Doctrine\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

trait UuidPrimaryKeyEntityTrait
{
    #[
        ORM\Id,
        ORM\Column(name: 'id', type: Types::GUID, unique: true, nullable: false),
    ]
    protected string $id;

    public function getUuid(): string
    {
        return $this->id;
    }

    public function setUuid(string $uuid): void
    {
        $this->id = $uuid;
    }

    #[Pure]
    public function getId(): string
    {
        return $this->getUuid();
    }
}
