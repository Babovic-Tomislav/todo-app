<?php

namespace Shared\Domain\Model;

abstract readonly class AbstractEntity
{
    public function __construct(protected AbstractEntityId $id)
    {
    }
}
