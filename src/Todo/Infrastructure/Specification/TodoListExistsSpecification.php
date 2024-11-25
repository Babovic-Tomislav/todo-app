<?php

namespace Todo\Infrastructure\Specification;

use Todo\Domain\Repository\TodoListRepositoryInterface;
use Todo\Domain\Specification\TodoListExistsSpecificationInterface;

class TodoListExistsSpecification implements TodoListExistsSpecificationInterface
{
    public function __construct(
        private TodoListRepositoryInterface $todoListRepository,
    ) {
    }

    /**
     * @param string $value
     */
    public function isSatisfiedBy(mixed $value): bool
    {
        return $this->todoListRepository->existsWith(['id' => $value]);
    }
}
