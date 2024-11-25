<?php

namespace Shared\Domain\Factory;

use Shared\Domain\Exception\DomainModelException;
use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Validation\AbstractDomainModelValidator;
use Shared\Domain\Validation\Result;

abstract readonly class AbstractDomainModelFactory
{
    public function __construct(
        protected AbstractDomainModelValidator $validator,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws DomainModelException
     */
    public function create(array $data): AbstractEntity
    {
        $validationResult = $this->validator->validate($data);

        if (!$validationResult->isValid()) {
            $this->throwValidationException($validationResult);
        }

        return $this->createEntity($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    abstract protected function createEntity(array $data): AbstractEntity;

    /**
     * @throws DomainModelException
     */
    protected function throwValidationException(Result $validationResult): void
    {
        throw DomainModelException::becauseInvalidData(\sprintf('Invalid data while creating: %s. %s', $this->getClass(), $validationResult->getErrors()[array_key_first($validationResult->getErrors())]));
    }

    abstract protected function getClass(): string;
}
