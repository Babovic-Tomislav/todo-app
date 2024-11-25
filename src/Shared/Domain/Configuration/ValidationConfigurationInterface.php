<?php

namespace Shared\Domain\Configuration;

interface ValidationConfigurationInterface
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function getValidationRules(): array;
}
