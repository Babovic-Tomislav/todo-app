<?php

namespace Shared\Domain\Translator;

interface TranslatorInterface
{
    /**
     * @param array<mixed> $parameters
     */
    public function translate(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string;
}
