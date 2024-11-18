<?php

namespace Shared\Infrastructure\Translator;

use Shared\Domain\Translator\TranslatorInterface;

readonly class Translator implements TranslatorInterface
{
    public function __construct(private \Symfony\Contracts\Translation\TranslatorInterface $translator)
    {
    }

    public function translate(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
    {
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }
}
