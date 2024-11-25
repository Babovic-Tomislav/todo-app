<?php

namespace Shared\Domain\Validation;

abstract class AbstractDomainModelValidator
{
    /**
     * @param array<string, mixed> $data
     */
    abstract public function validate(array $data): Result;
}
