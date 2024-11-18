<?php

namespace Shared\Domain\Model;

use Ramsey\Uuid\Uuid;

abstract readonly class AbstractEntityId
{
    protected string $uuid;

    public function __construct(?string $uuid = null)
    {
        if (null === $uuid) {
            $uuid = Uuid::uuid4();
        }

        if (!Uuid::isValid($uuid)) {
            throw new \InvalidArgumentException('Not valid UUID');
        }

        $this->uuid = $uuid;
    }

    public function getValue(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
