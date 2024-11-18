<?php

namespace User\Infrastructure\Specification;

use User\Domain\Repository\UserRepositoryInterface;
use User\Domain\Specification\IsUniqueEmailSpecificationInterface;

class IsUniqueEmailSpecification implements IsUniqueEmailSpecificationInterface
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    /**
     * @param string $value
     */
    public function isSatisfiedBy(mixed $value): bool
    {
        return $this->repository->existsWith(['email' => $value]);
    }
}
