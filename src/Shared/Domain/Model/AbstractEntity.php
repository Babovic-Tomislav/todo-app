<?php

namespace Shared\Domain\Model;

abstract class AbstractEntity
{
    public function __construct(protected AbstractEntityId $id)
    {
    }
}
