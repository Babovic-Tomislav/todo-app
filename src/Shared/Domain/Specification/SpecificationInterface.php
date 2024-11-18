<?php

namespace Shared\Domain\Specification;

interface SpecificationInterface
{
    public function isSatisfiedBy(mixed $value): bool;
}
