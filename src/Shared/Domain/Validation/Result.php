<?php

namespace Shared\Domain\Validation;

final readonly class Result
{
    /** @var array<string, mixed> */
    private array $errors;
    private bool $isValid;
    private ?string $customErrorMessage;

    /**
     * @param array<string, mixed> $errors
     */
    public function __construct(array $errors = [], ?string $customErrorMessage = null)
    {
        $this->errors = $errors;
        $this->isValid = 0 === \count($errors) && null === $customErrorMessage;
        $this->customErrorMessage = $customErrorMessage;
    }

    /** @return array<string, mixed> */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getCustomErrorMessage(): ?string
    {
        return $this->customErrorMessage;
    }

    public function withCustomMessage(string $customErrorMessage): self
    {
        return new self($this->errors, $customErrorMessage);
    }
}
