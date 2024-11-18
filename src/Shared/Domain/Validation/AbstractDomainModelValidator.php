<?php

namespace Shared\Domain\Validation;

use Shared\Domain\Translator\TranslatorInterface;

abstract class AbstractDomainModelValidator
{
    public function __construct(protected TranslatorInterface $translator)
    {
    }

    /**
     * @param array<string, mixed> $data
     */
    abstract public function validate(array $data): Result;
}
