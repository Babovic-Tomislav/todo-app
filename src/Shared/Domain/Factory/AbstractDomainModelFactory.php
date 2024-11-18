<?php

namespace Shared\Domain\Factory;

use Shared\Domain\Exception\DomainModelException;
use Shared\Domain\Model\AbstractEntity;
use Shared\Domain\Repository\DomainModelRepositoryInterface;
use Shared\Domain\Validation\AbstractDomainModelValidator;
use Shared\Domain\Validation\Result;

abstract readonly class AbstractDomainModelFactory
{
    public function __construct(
        protected AbstractDomainModelValidator $validator,
        protected DomainModelRepositoryInterface $repository,
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
    abstract protected function throwValidationException(Result $validationResult): void;
}
